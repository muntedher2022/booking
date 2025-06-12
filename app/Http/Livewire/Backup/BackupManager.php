<?php

namespace App\Http\Livewire\Backup;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Backup\Backup;
use App\Models\Tracking\Tracking;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class BackupManager extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $backup_type = 'full';
    public $processing = false;

    protected $listeners = ['refreshComponent' => '$refresh'];

    protected function getBackupPath()
    {
        $yearMonth = date('Y-m');
        $path = storage_path('app/public/backups/' . $yearMonth);

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $publicPath = public_path('storage');
        if (!file_exists($publicPath)) {
            Artisan::call('storage:link');
        }

        return $path;
    }

    public function render()
    {
        $backups = Backup::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('livewire.backup.backup-manager', [
            'backups' => $backups
        ]);
    }

    public function createBackup()
    {
        $this->emit('startBackup');
        $this->processing = true;

        try {
            $timestamp = Carbon::now()->format('Y-m-d-H-i-s');
            $yearMonth = date('Y-m');
            $success = false;

            switch ($this->backup_type) {
                case 'database':
                    $success = $this->backupDatabase($timestamp);
                    break;
                case 'files':
                    $success = $this->backupFiles($timestamp);
                    break;
                case 'full':
                    // في حالة النسخة الكاملة نقوم بإنشاء نسخة من قاعدة البيانات والملفات
                    $dbSuccess = $this->backupDatabase($timestamp);
                    $filesSuccess = $this->backupFiles($timestamp);

                    // نقوم بإنشاء سجل واحد للنسخة الكاملة
                    if ($dbSuccess && $filesSuccess) {
                        Backup::create([
                            'user_id' => Auth::id(),
                            'filename' => $yearMonth . '/full-' . $timestamp,
                            'type' => 'full',
                            'size' => $this->getFormattedSize($this->getBackupPath() . '/database-' . $timestamp . '.sql')
                                . ' + ' .
                                $this->getFormattedSize($this->getBackupPath() . '/files-' . $timestamp . '.zip')
                        ]);
                        $success = true;
                    }
                    break;
            }

            if ($success) {
                // تحديث تفاصيل التتبع
                $details = sprintf(
                    "نوع النسخة: %s\n" .
                    "اسم الملف: %s",
                    match ($this->backup_type) {
                        'database' => 'قاعدة البيانات',
                        'files' => 'ملفات النظام',
                        'full' => 'نسخة كاملة',
                        default => $this->backup_type
                    },
                    $yearMonth . '/' . ($this->backup_type === 'full' ? 'full-' . $timestamp : ($this->backup_type === 'database' ? "database-{$timestamp}.sql" : "files-{$timestamp}.zip"))
                );

                Tracking::create([
                    'user_id' => Auth::id(),
                    'page_name' => 'النسخ الاحتياطي',
                    'operation_type' => 'إنشاء نسخة احتياطية',
                    'operation_time' => now(),
                    'details' => $details
                ]);

                $this->dispatchBrowserEvent('success', [
                    'title' => 'نجاح',
                    'message' => 'تم إنشاء النسخة الاحتياطية بنجاح'
                ]);

                $this->reset(['backup_type']);
                $this->render();
            }
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', [
                'title' => 'خطأ',
                'message' => 'حدث خطأ أثناء إنشاء النسخة الاحتياطية: ' . $e->getMessage()
            ]);
        }

        $this->processing = false;
        $this->emit('endBackup');
    }

    private function backupDatabase($timestamp)
    {
        try {
            $yearMonth = date('Y-m');
            $filename = "database-{$timestamp}.sql";
            $filepath = $this->getBackupPath() . '/' . $filename;

            // تعديل الأمر لاستخدام المسار الكامل
            $command = sprintf(
                '"C:\xampp\mysql\bin\mysqldump" --user=%s --password=%s --host=%s --port=%s %s > %s',
                escapeshellarg(config('database.connections.mysql.username')),
                escapeshellarg(config('database.connections.mysql.password')),
                escapeshellarg(config('database.connections.mysql.host')),
                escapeshellarg(config('database.connections.mysql.port')),
                escapeshellarg(config('database.connections.mysql.database')),
                escapeshellarg($filepath)
            );

            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                throw new \Exception('فشل في إنشاء نسخة احتياطية من قاعدة البيانات');
            }

            // التحقق من إنشاء الملف ومحتواه
            if (!file_exists($filepath) || filesize($filepath) === 0) {
                throw new \Exception('فشل في حفظ ملف النسخ الاحتياطي');
            }

            // تسجيل في قاعدة البيانات فقط إذا لم تكن نسخة كاملة
            if ($this->backup_type !== 'full') {
                Backup::create([
                    'user_id' => Auth::id(),
                    'filename' => $yearMonth . '/' . $filename,
                    'type' => 'database',
                    'size' => $this->getFormattedSize($filepath)
                ]);
            }

            return true;
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', [
                'title' => 'خطأ',
                'message' => 'فشل في نسخ قاعدة البيانات: ' . $e->getMessage()
            ]);
            throw $e;
        }
    }

    private function backupFiles($timestamp)
    {
        try {
            $yearMonth = date('Y-m');
            $filename = "files-{$timestamp}.zip";
            $filepath = $this->getBackupPath() . '/' . $filename;
            $storagePath = storage_path('app/public');

            if (!file_exists($storagePath)) {
                throw new \Exception('مجلد الملفات المصدر غير موجود');
            }

            $zip = new \ZipArchive();

            if ($zip->open($filepath, \ZipArchive::CREATE) !== TRUE) {
                throw new \Exception('لا يمكن إنشاء ملف الضغط');
            }

            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($storagePath),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($storagePath) + 1);
                    $zip->addFile($filePath, $relativePath);
                }
            }

            $zip->close();

            if (!file_exists($filepath)) {
                throw new \Exception('فشل في إنشاء ملف الضغط');
            }

            // تسجيل في قاعدة البيانات فقط إذا لم تكن نسخة كاملة
            if ($this->backup_type !== 'full') {
                Backup::create([
                    'user_id' => Auth::id(),
                    'filename' => $yearMonth . '/' . $filename,
                    'type' => 'files',
                    'size' => $this->getFormattedSize($filepath)
                ]);
            }

            return true;
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', [
                'title' => 'خطأ',
                'message' => 'فشل في نسخ الملفات: ' . $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function mount()
    {
        // زيادة وقت التنفيذ
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '512M');
        set_time_limit(300);
    }

    private function addFilesToZipInBatches($zip, $path, $batchSize = 100)
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        $batch = [];
        $count = 0;

        foreach ($iterator as $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($path) + 1);

                $batch[] = [
                    'path' => $filePath,
                    'relativePath' => $relativePath
                ];

                $count++;

                if ($count >= $batchSize) {
                    $this->processBatch($zip, $batch);
                    $batch = [];
                    $count = 0;
                }
            }
        }

        // معالجة الملفات المتبقية
        if (!empty($batch)) {
            $this->processBatch($zip, $batch);
        }
    }

    private function processBatch($zip, $batch)
    {
        foreach ($batch as $file) {
            $zip->addFile($file['path'], $file['relativePath']);
        }
    }

    private function getFormattedSize($filepath)
    {
        $bytes = filesize($filepath);
        $units = ['B', 'KB', 'MB', 'GB'];
        $index = 0;

        while ($bytes >= 1024 && $index < count($units) - 1) {
            $bytes /= 1024;
            $index++;
        }

        return round($bytes, 2) . ' ' . $units[$index];
    }

    public function download($filename)
    {
        $filepath = storage_path('app/public/backups/' . $filename);

        if (file_exists($filepath)) {
            // تحديث تفاصيل التتبع
            $details = sprintf(
                "نوع الملف: %s\n" .
                "اسم الملف: %s",
                pathinfo($filename, PATHINFO_EXTENSION) === 'sql' ? 'قاعدة البيانات' : 'ملفات النظام',
                $filename
            );

            Tracking::create([
                'user_id' => Auth::id(),
                'page_name' => 'النسخ الاحتياطي',
                'operation_type' => 'تحميل نسخة احتياطية',
                'operation_time' => now(),
                'details' => $details
            ]);

            return response()->download($filepath);
        }

        $this->dispatchBrowserEvent('error', [
            'message' => 'الملف غير موجود',
            'title' => 'خطأ'
        ]);
    }

    public function delete($id)
    {
        $backup = Backup::find($id);
        if ($backup) {
            $yearMonth = dirname($backup->filename);
            try {
                // تحديث تفاصيل التتبع
                $details = sprintf(
                    "نوع النسخة: %s\n" .
                    "اسم الملف: %s",
                    match ($backup->type) {
                        'database' => 'قاعدة البيانات',
                        'files' => 'ملفات النظام',
                        'full' => 'نسخة كاملة',
                        default => $backup->type
                    },
                    $backup->filename
                );

                if ($backup->type === 'full') {
                    // حذف ملفات النسخة الكاملة
                    $timestamp = basename($backup->filename, '.sql');
                    $timestamp = str_replace('full-', '', $timestamp);

                    $dbFile = storage_path("app/public/backups/{$yearMonth}/database-{$timestamp}.sql");
                    $zipFile = storage_path("app/public/backups/{$yearMonth}/files-{$timestamp}.zip");

                    if (file_exists($dbFile)) {
                        unlink($dbFile);
                    }
                    if (file_exists($zipFile)) {
                        unlink($zipFile);
                    }
                } else {
                    // حذف ملف النسخة الفردية
                    $filepath = storage_path("app/public/backups/{$backup->filename}");
                    if (file_exists($filepath)) {
                        unlink($filepath);
                    }
                }

                // تسجيل عملية الحذف
                Tracking::create([
                    'user_id' => Auth::id(),
                    'page_name' => 'النسخ الاحتياطي',
                    'operation_type' => 'حذف نسخة احتياطية',
                    'operation_time' => now(),
                    'details' => $details
                ]);

                $backup->delete();

                $this->dispatchBrowserEvent('success', [
                    'title' => 'نجاح',
                    'message' => 'تم حذف النسخة الاحتياطية بنجاح'
                ]);

                $this->render();
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('error', [
                    'title' => 'خطأ',
                    'message' => 'حدث خطأ أثناء حذف النسخة الاحتياطية'
                ]);
            }
        }
    }
}
