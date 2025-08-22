<?php

namespace App\Http\Livewire\Report;

use App\Models\User;
use Livewire\Component;
use App\Models\Report\Report;
use App\Models\Sections\Sections;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Departments\Departments;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use App\Models\IncomingBooks\IncomingBooks;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReportComponent extends Component
{
    public $selectedColumns = [];
    public $filters = [];
    public $reportData = [];
    public $showResults = false;
    protected $originalData = null;

    protected $listeners = ['refreshComponent' => '$refresh', 'refreshReport' => 'generateReport'];

    public $availableColumns = [
        'book_number' => 'رقم الكتاب',
        'book_date' => 'تاريخ الكتاب',
        'subject' => 'الموضوع',
        'content' => 'المحتوى',
        'keywords' => 'الكلمات المفتاحية',
        'sender_type' => 'نطاق الكتاب',
        'book_type' => 'نوع الكتاب',
        'importance' => 'درجة الأهمية',
        'sender_id' => 'الجهة المرسلة',
        'related_book_id' => 'الكتاب المرتبط',
    ];

    public function generateReport()
    {
        if (empty($this->selectedColumns)) {
            session()->flash('error', 'الرجاء اختيار عمود واحد على الأقل');
            return;
        }

        try {
            // إضافة تسجيل للأخطاء للتحقق من البيانات
            Log::info('Report Filters', ['filters' => $this->filters]);

            // جلب معرفات الأقسام المرتبط بها المستخدم الحالي
            $userSectionIds = auth()->user()->sections->pluck('id')->toArray();

            // جلب جميع المستخدمين المرتبطين بنفس الأقسام
            $usersInSameSections = User::whereHas('sections', function($q) use ($userSectionIds) {
                $q->whereIn('sections.id', $userSectionIds);
            })->pluck('id')->unique()->toArray();

            // إنشاء الاستعلام وجلب البيانات
            $query = IncomingBooks::query()
                ->with(['relatedBook'])
                ->whereIn('user_id', $usersInSameSections); // إضافة فلتر المستخدمين

            // تطبيق الفلاتر
            if (!empty($this->filters['book_type'])) {
                $query->where('book_type', $this->filters['book_type']);
            }
            if (!empty($this->filters['sender_type'])) {
                $query->where('sender_type', $this->filters['sender_type']);
            }
            if (!empty($this->filters['importance'])) {
                $query->where('importance', $this->filters['importance']);
            }
            if (!empty($this->filters['date_from'])) {
                $query->whereDate('book_date', '>=', $this->filters['date_from']);
            }
            if (!empty($this->filters['date_to'])) {
                $query->whereDate('book_date', '<=', $this->filters['date_to']);
            }
            if (!empty($this->filters['keywords'])) {
                $query->where('keywords', 'like', '%' . $this->filters['keywords'] . '%');
            }
            if (!empty($this->filters['related_book_id'])) {
                $query->where('related_book_id', $this->filters['related_book_id']);
            }

            // تنفيذ الاستعلام الأساسي
            $results = $query->get();

            // تطبيق فلتر الجهة المرسلة باستخدام PHP (لأن JSON معقد في SQL)
            if (!empty($this->filters['sender_id'])) {
                Log::info('Applying sender filter', ['sender_ids' => $this->filters['sender_id']]);
                Log::info('Results before filter', ['count' => $results->count()]);

                $results = $results->filter(function($item) {
                    return $this->matchesSenderFilter($this->filters['sender_id'], $item->sender_id);
                });

                Log::info('Results after filter', ['count' => $results->count()]);
            }

            // تحضير البيانات للعرض
            $this->reportData = $results->map(function($item) {
                $data = collect($item->toArray())
                    ->only($this->selectedColumns)
                    ->toArray();

                // معالجة الجهة المرسلة
                if (in_array('sender_id', $this->selectedColumns)) {
                    $senderData = json_decode($item->sender_id, true);
                    $senderNames = [];

                    if (is_array($senderData)) {
                        foreach ($senderData as $sender) {
                            if ($sender['type'] === 'dep') {
                                $department = Departments::find($sender['id']);
                                if ($department) {
                                    $senderNames[] = $department->department_name;
                                }
                            } elseif ($sender['type'] === 'sec') {
                                $section = Sections::find($sender['id']);
                                if ($section) {
                                    $senderNames[] = $section->section_name;
                                }
                            }
                        }
                    }

                    $data['sender_id'] = implode(', ', $senderNames);
                }

                // معالجة الكتاب المرتبط
                if (in_array('related_book_id', $this->selectedColumns)) {
                    $data['related_book_id'] = $item->relatedBook ?
                        $item->relatedBook->book_number . ' - ' . $item->relatedBook->subject :
                        'لا يوجد';
                }

                return $data;
            })->toArray();

            // تسجيل عدد النتائج
            Log::info('Report Data Count', ['count' => count($this->reportData)]);

            if (empty($this->reportData)) {
                session()->flash('warning', 'لا توجد بيانات مطابقة للفلاتر المحددة');
                $this->showResults = false;
                return;
            }

            // حفظ التقرير في قاعدة البيانات
            Report::create([
                'title' => 'تقرير المخاطبات - ' . now()->format('Y-m-d H:i:s'),
                'source' => 'incomingbooks',
                'filters' => $this->filters,
                'columns' => $this->selectedColumns,
                'created_by' => Auth::id(),
                'status' => 'active'
            ]);

            $this->showResults = true;

            // إظهار رسالة نجاح
            $this->dispatchBrowserEvent('success', [
                'title' => 'تم إنشاء التقرير',
                'message' => 'تم إنشاء التقرير بنجاح'
            ]);

        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ أثناء إنشاء التقرير: ' . $e->getMessage());
        }
    }

    public function updatedSelectedColumns($value)
    {
        // إزالة إعادة التوليد التلقائي للتقرير
        if ($this->showResults) {
            // إعادة تعيين النتائج عند تغيير الأعمدة
            $this->showResults = false;
            $this->reportData = [];
        }
    }

    public function processReportData()
    {
        if (!$this->originalData) {
            return;
        }

        $this->reportData = [];

        foreach ($this->originalData as $item) {
            $row = [];
            foreach ($this->selectedColumns as $column) {
                // استخدام القيمة الفارغة إذا كان العمود غير موجود
                $row[$column] = $item->$column ?? '';
            }
            $this->reportData[] = $row;
        }
    }

    public function getColumnIcon($columnKey)
    {
        $icons = [
            'book_number' => 'mdi-pound',
            'book_date' => 'mdi-calendar',
            'subject' => 'mdi-text-box-outline',
            'content' => 'mdi-text-long',
            'keywords' => 'mdi-tag-multiple',
            'sender_type' => 'mdi-swap-horizontal',
            'book_type' => 'mdi-file-document-outline',
            'importance' => 'mdi-star-outline',
            'created_at' => 'mdi-clock-outline',
            'sender_id' => 'mdi-account-group',
            'related_book_id' => 'mdi-file-link-outline',
            'attachment' => 'mdi-paperclip',
            'status' => 'mdi-checkbox-marked-circle-outline'
        ];

        return $icons[$columnKey] ?? 'mdi-checkbox-blank-circle-outline';
    }

    public function getDepartments()
    {
        return Departments::orderBy('department_name')->get();
    }

    public function getSections()
    {
        return Sections::orderBy('section_name')->get();
    }

    public function getAvailableBooks()
    {
        return IncomingBooks::select('id', 'book_number', 'subject')
            ->orderBy('book_number')
            ->get();
    }

    /**
     * فحص ما إذا كانت الجهة المرسلة تطابق المعايير المحددة
     */
    private function matchesSenderFilter($senderIds, $senderJsonData)
    {
        if (empty($senderIds) || empty($senderJsonData)) {
            return true; // لا توجد فلاتر أو بيانات
        }

        $senderData = json_decode($senderJsonData, true);
        if (!is_array($senderData)) {
            Log::info('Invalid JSON data:', ['data' => $senderJsonData]);
            return false;
        }

        // تسجيل عينة للتشخيص
        if (rand(1, 100) <= 5) { // تسجيل 5% من الحالات
            Log::info('Sender filter debug:', [
                'filter_ids' => $senderIds,
                'sender_data' => $senderData
            ]);
        }

        foreach ($senderIds as $filterId) {
            $parts = explode('_', $filterId);
            if (count($parts) == 2) {
                $filterType = $parts[0]; // dep أو sec
                $filterId = $parts[1];   // المعرف

                foreach ($senderData as $sender) {
                    if (isset($sender['type']) && isset($sender['id']) &&
                        $sender['type'] === $filterType && $sender['id'] == $filterId) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function exportToExcel()
    {
        if (empty($this->reportData)) {
            session()->flash('error', 'لا توجد بيانات للتصدير');
            return;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setRightToLeft(true);

        // إضافة العناوين
        $headers = [];
        foreach ($this->selectedColumns as $column) {
            $headers[] = $this->availableColumns[$column];
        }
        $sheet->fromArray([$headers], null, 'A1');

        // تنسيق العناوين
        $headerStyle = [
            'font' => ['bold' => true, 'size' => 12],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '696CFF']
            ],
            'font' => [
                'color' => ['rgb' => 'FFFFFF']
            ]
        ];

        $lastColumn = $sheet->getHighestColumn();
        $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray($headerStyle);

        // إضافة البيانات
        $row = 2;
        foreach ($this->reportData as $data) {
            $rowData = [];
            foreach ($this->selectedColumns as $column) {
                $rowData[] = $data[$column] ?? '';
            }
            $sheet->fromArray([$rowData], null, "A{$row}");
            $row++;
        }

        // تنسيق البيانات
        $dataStyle = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ]
        ];

        if ($row > 2) {
            $sheet->getStyle("A2:{$lastColumn}" . ($row-1))->applyFromArray($dataStyle);
        }

        // تعديل عرض الأعمدة
        foreach (range('A', $lastColumn) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // حفظ الملف
        $fileName = 'تقرير_' . date('Y-m-d_H-i-s') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        $path = storage_path('app/public/reports');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $filePath = $path . '/' . $fileName;
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }

    public function render()
    {
        return view('livewire.report.index');
    }
}
