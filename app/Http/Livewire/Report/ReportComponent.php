<?php

namespace App\Http\Livewire\Report;

use Livewire\Component;
use App\Models\Incomingbooks\Incomingbooks;
use App\Models\Departments\Departments;
use App\Models\Sections\Sections;
use App\Models\Report\Report;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

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
        // ... باقي الأعمدة
    ];

    public function generateReport()
    {
        if (empty($this->selectedColumns)) {
            session()->flash('error', 'الرجاء اختيار عمود واحد على الأقل');
            return;
        }

        try {
            // إنشاء الاستعلام وجلب البيانات
            $query = Incomingbooks::query()
                ->select($this->selectedColumns);

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
            if (!empty($this->filters['sender_id'])) {
                $query->where(function($q) {
                    foreach ($this->filters['sender_id'] as $sender) {
                        $q->orWhere('sender_id', 'like', '%' . $sender . '%');
                    }
                });
            }

            // تنفيذ الاستعلام وتحضير البيانات
            $this->reportData = $query->get()->map(function($item) {
                return collect($item->toArray())
                    ->only($this->selectedColumns)
                    ->toArray();
            })->toArray();

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
