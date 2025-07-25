<?php

namespace App\Http\Livewire\Incomingbooks;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;

use Illuminate\Http\Request;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use App\Models\Sections\Sections;
use App\Models\Tracking\Tracking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Emaillists\Emaillists;
use App\Mail\IncomingBookNotification;
use App\Models\Departments\Departments;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Incomingbooks\Incomingbooks;

class Incomingbook extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $Incomingbooks = null;
    public $departments = [];
    public $sections = [];
    public $sender_id = [];
    public $sender_type = '';
    public $Incomingbook, $IncomingbookId;
    public $book_number, $book_date, $subject, $content, $keywords, $related_book_id, $attachment, $annotated_attachment, $book_type, $importance;
    public $previewIncomingbookImage, $previewAnnotatedIncomingbookImage;
    public $search = ['book_number' => '', 'book_date' => '', 'subject' => '', 'content' => '', 'related_book_id' => '', 'sender_type' => '', 'sender_id' => '', 'book_type' => '', 'importance' => ''];
    public $sendEmail = false;
    public $todayEmailCount = 0;
    public $remainingEmails = 450;
    public $tempImageUrl, $tempAnnotatedImageUrl = null;
    public $selectedRows = [];
    public $selectAll = false;
    public $needs_reply = false;

    protected $listeners = [
        'GetSenderId',
        'GetDepAndSec',
        'showIncomingbookbook' => 'handleBookDateUpdated',
        'showError',
        'updatedSelectAll',
    ];

    public function hydrate()
    {
        $this->emit('select2');
        $this->emit('flatpickr');

        // حذف الملفات المؤقتة التي مر عليها يومين
        $path = storage_path('app/public/uploads');
        if (file_exists($path)) {
            $files = glob($path . '/*');
            $twoDaysAgo = strtotime('-2 days');

            foreach ($files as $file) {
                if (is_file($file) && filemtime($file) < $twoDaysAgo) {
                    unlink($file);
                }
            }
        }
    }

    public function mount()
    {
        $this->sections = Sections::all();
        $this->departments = Departments::all();
        $this->updateEmailCounter();
    }

    private function updateEmailCounter()
    {
        $today = date('Y-m-d');
        $count = DB::table('daily_email_counts')
            ->whereDate('date', $today)
            ->first();

        if ($count) {
            $this->todayEmailCount = $count->count;
        } else {
            // إذا لم يكن هناك سجل لهذا اليوم، نقوم بإنشاء واحد
            DB::table('daily_email_counts')->insert([
                'date' => $today,
                'count' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $this->todayEmailCount = 0;
        }

        $this->remainingEmails = 450 - $this->todayEmailCount;
    }

    private function incrementEmailCounter($count)
    {
        $today = date('Y-m-d');
        DB::table('daily_email_counts')
            ->updateOrInsert(
                ['date' => $today],
                ['count' => DB::raw("COALESCE(count, 0) + $count")]
            );

        $this->updateEmailCounter();
    }

    public function handleBookDateUpdated($value)
    {
        $this->search['book_date'] = $value;
        $this->resetPage();
    }

    public function updatedSearch($value, $key)
    {
        if (in_array($key, ['book_number', 'book_date', 'subject', 'content', 'related_book_id', 'sender_type', 'sender_id', 'book_type', 'importance'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $this->updateEmailCounter();
        $userSectionIds = auth()->user()->sections->pluck('id')->toArray();
        $usersInSameSections = User::whereHas('sections', function($q) use ($userSectionIds) {
            $q->whereIn('sections.id', $userSectionIds);
        })->pluck('id')->unique()->toArray();

        $book_numberSearch = '%' . $this->search['book_number'] . '%';
        $book_dateSearch = '%' . $this->search['book_date'] . '%';
        $subjectSearch = '%' . $this->search['subject'] . '%';
        $contentSearch = '%' . $this->search['content'] . '%';
        $related_book_idSearch = '%' . $this->search['related_book_id'] . '%';
        $sender_typeSearch = '%' . $this->search['sender_type'] . '%';
        $sender_idSearch = '%' . $this->search['sender_id'] . '%';
        $book_typeSearch = '%' . $this->search['book_type'] . '%';
        $importanceSearch = '%' . $this->search['importance'] . '%';

        $Incomingbooks = Incomingbooks::query()
            ->whereIn('user_id', $usersInSameSections)
            ->when($this->search['book_number'], function ($query) use ($book_numberSearch) {
                $query->where('book_number', 'LIKE', $book_numberSearch);
            })
            ->when($this->search['book_date'], function ($query) use ($book_dateSearch) {
                $query->where('book_date', 'LIKE', $book_dateSearch);
            })
            ->when($this->search['subject'], function ($query) use ($subjectSearch) {
                $query->where('subject', 'LIKE', $subjectSearch);
            })
            ->when($this->search['content'], function ($query) use ($contentSearch) {
                $query->where('content', 'LIKE', $contentSearch);
            })
            ->when($this->search['related_book_id'], function ($query) use ($related_book_idSearch) {
                $query->whereHas('relatedBook', function ($q) use ($related_book_idSearch) {
                    $q->where('book_number', 'LIKE', $related_book_idSearch);
                });
            })
            ->when($this->search['sender_type'], function ($query) use ($sender_typeSearch) {
                $query->where('sender_type', 'LIKE', $sender_typeSearch);
            })
            ->when($this->search['book_type'], function ($query) use ($book_typeSearch) {
                $query->where('book_type', 'LIKE', $book_typeSearch);
            })
            // إضافة شرط البحث بدرجة الأهمية
            ->when($this->search['importance'], function ($query) use ($importanceSearch) {
                $query->where('importance', 'LIKE', $importanceSearch);
            })
            ->when($this->search['sender_id'], function ($query) use ($sender_idSearch) {
                $query->where(function ($subQuery) use ($sender_idSearch) {
                    // البحث في الأقسام
                    $sectionIds = Sections::where('section_name', 'LIKE', '%' . $this->search['sender_id'] . '%')
                        ->pluck('id')
                        ->map(function ($id) {
                            return ['type' => 'sec', 'id' => $id];
                        })
                        ->toArray();

                    // البحث في الدوائر
                    $departmentIds = Departments::where('department_name', 'LIKE', '%' . $this->search['sender_id'] . '%')
                        ->pluck('id')
                        ->map(function ($id) {
                            return ['type' => 'dep', 'id' => $id];
                        })
                        ->toArray();

                    $allIds = array_merge($sectionIds, $departmentIds);

                    if (!empty($allIds)) {
                        foreach ($allIds as $item) {
                            $jsonPattern = '%"type":"' . $item['type'] . '","id":' . $item['id'] . '%';
                            $subQuery->orWhere('sender_id', 'LIKE', $jsonPattern);
                        }
                    }
                });
            })
            ->orderBy('id', 'ASC')
            ->paginate(10);

        $links = $Incomingbooks;
        // تحويل النتائج إلى Collection
        $this->Incomingbooks = collect($Incomingbooks->items());

        return view('livewire.incomingbooks.incomingbook', [
            'Departments' => $Incomingbooks,
            'links' => $links,
            'incomingbooks' => $Incomingbooks
        ]);
    }

    public function GetDepAndSec($sender_id)
    {
        if ($sender_id) {
            $this->sender_id = $sender_id;
        } else {
            $this->sender_id = null;
        }
    }

    public function GetSenderId($RelatedBookIdID)
    {
        $related_book_id = Incomingbooks::find($RelatedBookIdID);
        if ($related_book_id) {
            $this->related_book_id = $RelatedBookIdID;
        } else {
            $this->related_book_id = null;
        }
    }

    public function updatedSenderType($value)
    {
        $this->reset('sender_id');
        $this->dispatchBrowserEvent('initAddSelect2', [
            'selector' => '#addIncomingbooksender_id',
            'values' => $this->sender_id
        ]);

        $this->dispatchBrowserEvent('initEditSelect2', [
            'selector' => '#editIncomingbooksender_id',
            'values' => $this->sender_id
        ]);
    }

    public function updatedAttachment()
    {
        $this->validate([
            'attachment' => 'required|file|mimes:jpeg,png,jpg,pdf|max:20480',
        ], [
            'attachment.required' => 'ملف الكتاب مطلوب.',
            'attachment.max' => 'يجب ألا يزيد حجم ملف الكتاب عن 20 ميجا.',
            'attachment.mimes' => 'الملف ليس صورة أو PDF',
        ]);

        if ($this->attachment) {
            $path = $this->attachment->store('public/uploads');
            $this->tempImageUrl = Storage::url($path);
            $this->previewIncomingbookImage = null;
        }
    }

    public function updatedAnnotatedAttachment()
    {
        $this->validate([
            'annotated_attachment' => 'required|file|mimes:jpeg,png,jpg,pdf|max:20480',
        ], [
            'annotated_attachment.required' => 'ملف الكتاب المؤشر عليه مطلوب.',
            'annotated_attachment.max' => 'يجب ألا يزيد حجم الملف عن 20 ميجا.',
            'annotated_attachment.mimes' => 'الملف ليس صورة أو PDF',
        ]);

        if ($this->annotated_attachment) {
            $path = $this->annotated_attachment->store('public/uploads');
            $this->tempAnnotatedImageUrl = Storage::url($path);
            $this->previewAnnotatedIncomingbookImage = null;
        }
    }

    /*  public function updatedIncomingbookImage()
    {
        $this->validate([
            'attachment' => 'required|file|mimes:jpeg,png,jpg,pdf|max:20480',
        ], [
            'attachment.required' => 'ملف الكتاب مطلوب.',
            'attachment.max' => 'يجب ألا يزيد حجم ملف الكتاب عن 20 ميجا.',
            'attachment.mimes' => 'الملف ليس صورة أو PDF',
        ]);

        // Instead of using temporaryUrl, store the file temporarily and use its URL
        $path = $this->attachment->store('public/temp');
        $this->filePreview = Storage::url($path);
    } */

    public function AddIncomingbookModalShow()
    {
        $this->reset('book_number', 'book_date', 'subject', 'content', 'keywords', 'related_book_id', 'sender_type', 'sender_id', 'attachment', 'tempImageUrl', 'annotated_attachment', 'tempAnnotatedImageUrl', 'book_type', 'importance');
        $this->resetValidation();
        $this->dispatchBrowserEvent('IncomingbookModalShow');
        $this->dispatchBrowserEvent('resetFileInput', ['input' => 'attachment']);
        $this->dispatchBrowserEvent('resetFileInput', ['input' => 'annotated_attachment']);
    }

    public function GetIncomingbook($IncomingbookId)
    {
        $this->reset('book_number', 'book_date', 'subject', 'content', 'keywords', 'related_book_id', 'sender_type', 'sender_id', 'attachment', 'annotated_attachment', 'tempAnnotatedImageUrl', 'book_type', 'importance');
        $this->resetValidation();

        $this->Incomingbook = Incomingbooks::with('relatedBook')->find($IncomingbookId);

        if (!$this->Incomingbook) {
            return;
        }

        $this->dispatchBrowserEvent('editincomingbookModal');

        $this->IncomingbookId = $this->Incomingbook->id;
        $this->book_number = $this->Incomingbook->book_number;
        $this->book_date = Carbon::parse($this->Incomingbook->book_date)->format('d/m/Y');
        $this->subject = $this->Incomingbook->subject;
        $this->content = $this->Incomingbook->content;
        $this->keywords = $this->Incomingbook->keywords;
        $this->related_book_id = $this->Incomingbook->related_book_id;
        $this->sender_type = $this->Incomingbook->sender_type;

        // تحويل البيانات المخزنة إلى الصيغة المناسبة للعرض في النموذج
        $senderData = json_decode($this->Incomingbook->sender_id, true) ?? [];
        $formattedSenderIds = array_map(function ($item) {
            return $item['type'] . '_' . $item['id'];
        }, $senderData);
        $this->sender_id = $formattedSenderIds;

        $this->book_type = $this->Incomingbook->book_type;
        $this->importance = $this->Incomingbook->importance;
        $this->needs_reply = $this->Incomingbook->needs_reply;

        // تنظيف وتهيئة الكلمات المفتاحية
        if ($this->Incomingbook->keywords) {
            $this->keywords = $this->Incomingbook->keywords;
            // إرسال حدث لتحديث حقل Tagify
            $this->dispatchBrowserEvent('initKeywords', [
                'selector' => '#editIncomingbookkeywords',
                'tags' => explode(',', $this->keywords)
            ]);
        }

        if ($this->Incomingbook->attachment) {
            $year = date('Y', strtotime($this->Incomingbook->book_date));
            $bookNumber = $this->Incomingbook->book_number;
            $attachment = $this->Incomingbook->attachment;
            $this->previewIncomingbookImage = "Incomingbooks/{$year}/{$bookNumber}/{$attachment}";
            if (Storage::disk('public')->exists($this->previewIncomingbookImage)) {
                $this->tempImageUrl = null;
            } else {
                $this->previewIncomingbookImage = null;
            }
        } else {
            $this->previewIncomingbookImage = null;
            $this->tempImageUrl = null;
        }

        if ($this->Incomingbook->annotated_attachment) {
            $year = date('Y', strtotime($this->Incomingbook->book_date));
            $bookNumber = $this->Incomingbook->book_number;
            $annotatedAttachment = $this->Incomingbook->annotated_attachment;
            $this->previewAnnotatedIncomingbookImage = "Incomingbooks/{$year}/{$bookNumber}/{$annotatedAttachment}";
            if (Storage::disk('public')->exists($this->previewAnnotatedIncomingbookImage)) {
                $this->tempAnnotatedImageUrl = null;
            } else {
                $this->previewAnnotatedIncomingbookImage = null;
            }
        } else {
            $this->previewAnnotatedIncomingbookImage = null;
            $this->tempAnnotatedImageUrl = null;
        }


        $this->dispatchBrowserEvent('initEditSelect2', [
            'selector' => '#editIncomingbooksender_id',
            'values' => $this->sender_id
        ]);
    }

    private function formatDate($date)
    {
        if (!$date) return null;
        try {
            // محاولة تحويل التاريخ من صيغة d/m/Y إلى Y-m-d
            return Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
        } catch (\Exception $e) {
            try {
                // محاولة تحويل التاريخ من أي صيغة إلى Y-m-d
                return Carbon::parse($date)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }
    }

    private function sendEmailNotification($processed_sender_ids, $bookData)
    {
        $sentEmails = [];
        $failedEmails = [];

        // إضافة مسار الملف المرفق
        $year = date('Y', strtotime($bookData['book_date']));
        $attachmentPath = storage_path('app/public/Incomingbooks/' . $year . '/' . $bookData['book_number'] . '/' . $bookData['attachment']);

        foreach ($processed_sender_ids as $sender) {
            $entityType = $sender['type'] == 'dep' ? 'department' : 'section';
            $emails = Emaillists::where('type', $entityType)
                ->where('department', $sender['id'])
                ->get();

            if ($emails->isEmpty()) {
                $entityName = $entityType == 'department'
                    ? optional(Departments::find($sender['id']))->department_name
                    : optional(Sections::find($sender['id']))->section_name;
                $failedEmails[] = "لا يوجد بريد إلكتروني مسجل لـ {$entityName}";
                continue;
            }

            foreach ($emails as $emailRecord) {
                try {
                    Mail::to($emailRecord->email)
                        ->send(new IncomingBookNotification($bookData, $attachmentPath));

                    $sentEmails[] = [
                        'email' => $emailRecord->email,
                        'entity' => $entityType == 'department'
                            ? optional(Departments::find($sender['id']))->department_name
                            : optional(Sections::find($sender['id']))->section_name
                    ];
                } catch (\Exception $e) {
                    $errorMessage = "فشل إرسال البريد إلى {$emailRecord->email}";
                    if (str_contains($e->getMessage(), 'Failed to authenticate')) {
                        $errorMessage .= " - خطأ في المصادقة";
                    }
                    $failedEmails[] = $errorMessage;
                }
            }
        }

        $message = '';
        if (!empty($sentEmails)) {
            $message .= "تم إرسال البريد بنجاح إلى:<br>";
            foreach ($sentEmails as $sent) {
                $message .= "- {$sent['entity']}: {$sent['email']}<br>";
            }
        }
        if (!empty($failedEmails)) {
            $message .= "<br>لم يتم الإرسال:<br>";
            foreach ($failedEmails as $failed) {
                $message .= "- {$failed}<br>";
            }
        }

        if (empty($sentEmails) && empty($failedEmails)) {
            $message = "لا توجد عناوين بريد إلكتروني للإرسال";
        }

        return [
            'success' => !empty($sentEmails),
            'message' => $message
        ];
    }

    public function store()
    {
        $this->resetValidation();
        $formatted_date = $this->formatDate($this->book_date);

        if (!$formatted_date) {
            $this->addError('book_date', 'التاريخ غير صالح');
            return;
        }

        $this->validate([
            'book_number' => [
                'required',
                Rule::unique('incomingbooks')->where(function ($query) use ($formatted_date) {
                    return $query->whereYear('book_date', Carbon::parse($formatted_date)->year);
                }),
            ],
            'book_date' => 'required',
            'subject' => 'required',
            'sender_type' => 'required',
            'sender_id' => 'required|array',
            'sender_id.*' => ['required', 'string', 'regex:/^(dep|sec)_[0-9]+$/'],
            'attachment' => 'required|file|mimes:jpeg,png,jpg,pdf|max:20480',
            'annotated_attachment' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:20480',
            'book_type' => 'required|in:صادر,وارد',
            'importance' => 'required|in:عادي,عاجل,سري,سري للغاية',
        ], [
            'book_number.required' => 'حقل رقم الكتاب مطلوب',
            'book_number.unique' => 'رقم الكتاب مكرر خلال السنة الحالية',
            'book_date.required' => 'حقل تاريخ الكتاب مطلوب',
            'subject.required' => 'حقل موضوع الكتاب مطلوب',
            'sender_type.required' => 'حقل نطاق الكتاب مطلوب',
            'sender_id.required' => 'حقل الجهة المرسلة للكتاب مطلوب',
            'sender_id.array' => 'يجب اختيار جهة واحدة على الأقل',
            'sender_id.*.integer' => 'يجب أن تكون القيم المختارة صحيحة',
            'attachment.required' => 'ملف الكتاب مطلوب',
            'attachment.max' => 'يجب ألا يزيد حجم ملف الكتاب عن 20 ميجا.',
            'attachment.mimes' => 'الملف ليس صورة أو PDF',
            'annotated_attachment.max' => 'يجب ألا يزيد حجم الملف المؤشر عليه عن 20 ميجا.',
            'annotated_attachment.mimes' => 'الملف المؤشر عليه ليس صورة أو PDF',
            'book_type.required' => 'حقل نوع الكتاب مطلوب',
            'book_type.in' => 'قيمة نوع الكتاب غير صحيحة',
            'importance.required' => 'حقل درجة الأهمية مطلوب',
            'importance.in' => 'قيمة درجة الأهمية غير صحيحة',
        ]);

        $year = date('Y', strtotime($formatted_date));
        $this->attachment->store('public/Incomingbooks/' . $year . '/' . $this->book_number);
        $this->annotated_attachment->store('public/Incomingbooks/' . $year . '/' . $this->book_number);

        // معالجة sender_id قبل الحفظ
        $processed_sender_ids = array_map(function ($id) {
            $parts = explode('_', $id);
            return [
                'type' => $parts[0],
                'id' => intval($parts[1])
            ];
        }, $this->sender_id);

        // تنظيف الكلمات المفتاحية قبل الحفظ
        $keywords = $this->keywords ? trim($this->keywords, ', ') : null;

        $incomingBook = Incomingbooks::create([
            'user_id' => Auth::User()->id,
            'book_number' => $this->book_number,
            'book_date' => $formatted_date,
            'subject' => $this->subject,
            'content' => $this->content,
            'keywords' => $keywords,
            'related_book_id' => $this->related_book_id,
            'sender_type' => $this->sender_type,
            'sender_id' => json_encode($processed_sender_ids),
            'attachment' => $this->attachment->hashName(),
            'annotated_attachment' => $this->annotated_attachment->hashName(),
            'book_type' => $this->book_type,
            'importance' => $this->importance,
            'needs_reply' => $this->needs_reply,
        ]);

        // تحضير تفاصيل التتبع
        $departments = $this->getSenderDetails('dep');
        $sections = $this->getSenderDetails('sec');

        $details = sprintf(
            "رقم الكتاب: %s\n" .
                "تاريخ الكتاب: %s\n" .
                "موضوع الكتاب: %s\n" .
                "محتوى الكتاب: %s\n" .
                "الكلمات المفتاحية: %s\n" .
                "نوع الكتاب: %s\n" .
                "نطاق الكتاب: %s\n" .
                "درجة الأهمية: %s\n" .
                "يحتاج لإجابة: %s\n" .
                "الجهات:\n%s%s%s",
            $this->book_number ?: 'غير محدد',
            $this->book_date ?: 'غير محدد',
            $this->subject ?: 'غير محدد',
            $this->content ?: 'غير محدد',
            $this->keywords ?: 'غير محدد',
            $this->book_type ?: 'غير محدد',
            $this->sender_type ?: 'غير محدد',
            $this->importance ?: 'غير محدد',
            $this->needs_reply ? 'نعم' : 'لا',
            $departments ? $departments . "\n" : '',
            $sections ? $sections . "\n" : '',
            (!$departments && !$sections) ? "لا توجد جهات\n" : ''
        );

        Tracking::create([
            'user_id' => Auth::id(),
            'page_name' => 'الكتب الواردة',
            'operation_type' => 'اضافة',
            'operation_time' => now()->format('Y-m-d H:i:s'),
            'details' => $details
        ]);

        if ($this->sendEmail) {
            $emailCount = count($processed_sender_ids);

            if (($this->todayEmailCount + $emailCount) > 450) {
                $this->dispatchBrowserEvent('error', [
                    'message' => 'تم تجاوز الحد الأقصى للرسائل اليومية (450)',
                    'title' => 'خطأ في الإرسال'
                ]);
                return;
            }

            $bookData = [
                'book_number' => $this->book_number,
                'book_date' => $formatted_date,
                'subject' => $this->subject,
                'importance' => $this->importance,
                'book_type' => $this->book_type,
                'attachment' => $this->attachment->hashName(),
                'annotated_attachment' => $this->annotated_attachment->hashName(),
            ];

            $emailResult = $this->sendEmailNotification($processed_sender_ids, $bookData);
            $this->dispatchBrowserEvent('showDelayedMessage', [
                'message' => 'تم ارسال نسخة من الكتاب عبر البريد الالكتروني',
                'title' => 'البريد الالكتروني'
            ]);

            $this->incrementEmailCounter($emailCount);
        }

        $this->reset('book_number', 'book_date', 'subject', 'content', 'keywords', 'related_book_id', 'sender_type', 'sender_id', 'attachment', 'annotated_attachment', 'book_type', 'importance');

        $this->dispatchBrowserEvent('success', [
            'message' => 'تم الاضافه بنجاح',
            'title' => 'اضافه'
        ]);
    }

    public function update()
    {
        $this->resetValidation();
        $formatted_date = $this->formatDate($this->book_date);

        if (!$formatted_date) {
            $this->addError('book_date', 'التاريخ غير صالح');
            return;
        }

        $this->validate([
            'book_number' => [
                'required',
                Rule::unique('incomingbooks')->where(function ($query) use ($formatted_date) {
                    return $query->whereYear('book_date', Carbon::parse($formatted_date)->year);
                })->ignore($this->IncomingbookId),
            ],
            'book_date' => 'required',
            'subject' => 'required',
            'sender_type' => 'required',
            'sender_id' => 'required|array',
            'sender_id.*' => ['required', 'string', 'regex:/^(dep|sec)_[0-9]+$/'],
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:20480',
            'annotated_attachment' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:20480',
            'book_type' => 'required|in:صادر,وارد',
            'importance' => 'required|in:عادي,عاجل,سري,سري للغاية',
        ], [
            'book_number.required' => 'حقل رقم الكتاب مطلوب',
            'book_number.unique' => 'رقم الكتاب مكرر خلال السنة الحالية',
            'book_date.required' => 'حقل تاريخ الكتاب مطلوب',
            'subject.required' => 'حقل موضوع الكتاب مطلوب',
            'sender_type.required' => 'حقل نطاق الكتاب مطلوب',
            'sender_id.required' => 'حقل الجهة المرسلة للكتاب مطلوب',
            'sender_id.array' => 'يجب اختيار جهة واحدة على الأقل',
            'sender_id.*.integer' => 'يجب أن تكون القيم المختارة صحيحة',
            'attachment.mimes' => 'الملف ليس صورة أو PDF',
            'attachment.max' => 'يجب ألا يزيد حجم ملف الكتاب عن 20 ميجا.',
            'annotated_attachment.max' => 'يجب ألا يزيد حجم الملف المؤشر عليه عن 20 ميجا.',
            'annotated_attachment.mimes' => 'الملف المؤشر عليه ليس صورة أو PDF',
            'book_type.required' => 'حقل نوع الكتاب مطلوب',
            'book_type.in' => 'قيمة نوع الكتاب غير صحيحة',
            'importance.required' => 'حقل درجة الأهمية مطلوب',
            'importance.in' => 'قيمة درجة الأهمية غير صحيحة',
        ]);

        $Incomingbooks = Incomingbooks::find($this->IncomingbookId);
        $year = date('Y', strtotime($formatted_date));

        if ($this->attachment) {
            if ($Incomingbooks->attachment) {
                Storage::delete('public/Incomingbooks/' . $year . '/' . $this->book_number . '/' . $Incomingbooks->attachment);
            }
            $filePath = $this->attachment->store('public/Incomingbooks/' . $year . '/' . $this->book_number);
            $Incomingbooks->attachment = basename($filePath);
        }

        if ($this->annotated_attachment) {
            if ($Incomingbooks->annotated_attachment) {
                Storage::delete('public/Incomingbooks/' . $year . '/' . $this->book_number . '/' . $Incomingbooks->annotated_attachment);
            }
            $filePath = $this->annotated_attachment->store('public/Incomingbooks/' . $year . '/' . $this->book_number);
            $Incomingbooks->annotated_attachment = basename($filePath);
        }


        // معالجة sender_id قبل التحديث
        $processed_sender_ids = array_map(function ($id) {
            $parts = explode('_', $id);
            return [
                'type' => $parts[0],
                'id' => intval($parts[1])
            ];
        }, $this->sender_id);

        // تنظيف الكلمات المفتاحية قبل التحديث
        $keywords = $this->keywords ? trim($this->keywords, ', ') : null;

        $Incomingbooks->update([
            'user_id' => Auth::User()->id,
            'book_number' => $this->book_number,
            'book_date' => $formatted_date,
            'subject' => $this->subject,
            'content' => $this->content,
            'keywords' => $keywords,
            'related_book_id' => $this->related_book_id,
            'sender_type' => $this->sender_type,
            'sender_id' => json_encode($processed_sender_ids),
            'book_type' => $this->book_type,
            'importance' => $this->importance,
            'needs_reply' => $this->needs_reply,
        ]);

        // تحضير تفاصيل التتبع
        $departments = $this->getSenderDetails('dep');
        $sections = $this->getSenderDetails('sec');

        $details = sprintf(
            "رقم الكتاب: %s\n" .
                "تاريخ الكتاب: %s\n" .
                "موضوع الكتاب: %s\n" .
                "محتوى الكتاب: %s\n" .
                "الكلمات المفتاحية: %s\n" .
                "نوع الكتاب: %s\n" .
                "نطاق الكتاب: %s\n" .
                "درجة الأهمية: %s\n" .
                "يحتاج لإجابة: %s\n" .
                "الجهات:\n%s%s%s",
            $this->book_number ?: 'غير محدد',
            $this->book_date ?: 'غير محدد',
            $this->subject ?: 'غير محدد',
            $this->content ?: 'غير محدد',
            $this->keywords ?: 'غير محدد',
            $this->book_type ?: 'غير محدد',
            $this->sender_type ?: 'غير محدد',
            $this->importance ?: 'غير محدد',
            $this->needs_reply ? 'نعم' : 'لا',
            $departments ? $departments . "\n" : '',
            $sections ? $sections . "\n" : '',
            (!$departments && !$sections) ? "لا توجد جهات\n" : ''
        );

        Tracking::create([
            'user_id' => Auth::id(),
            'page_name' => 'الكتب الواردة',
            'operation_type' => 'تعديل',
            'operation_time' => now()->format('Y-m-d H:i:s'),
            'details' => $details
        ]);

        $this->reset('book_number', 'book_date', 'subject', 'content', 'keywords', 'related_book_id', 'sender_type', 'sender_id', 'attachment', 'annotated_attachment', 'book_type', 'importance');
        $this->dispatchBrowserEvent('success', [
            'message' => 'تم التعديل بنجاح',
            'title' => 'تعديل'
        ]);
    }

    public function destroy()
    {
        $Incomingbooks = Incomingbooks::find($this->IncomingbookId);

        if ($Incomingbooks) {
            // تحضير تفاصيل التتبع
            $departments = $Incomingbooks->Getdepartment()->pluck('department_name')
                ->map(fn($name) => "دائرة: " . $name)->join("\n");
            $sections = $Incomingbooks->Getsection()->pluck('section_name')
                ->map(fn($name) => "قسم: " . $name)->join("\n");

            $details = sprintf(
                "رقم الكتاب: %s\n" .
                    "تاريخ الكتاب: %s\n" .
                    "موضوع الكتاب: %s\n" .
                    "محتوى الكتاب: %s\n" .
                    "الكلمات المفتاحية: %s\n" .
                    "نوع الكتاب: %s\n" .
                    "نطاق الكتاب: %s\n" .
                    "درجة الأهمية: %s\n" .
                    "يحتاج لإجابة: %s\n" .
                    "الجهات:\n%s%s%s",
                $this->book_number ?: 'غير محدد',
                $this->book_date ?: 'غير محدد',
                $this->subject ?: 'غير محدد',
                $this->content ?: 'غير محدد',
                $this->keywords ?: 'غير محدد',
                $this->book_type ?: 'غير محدد',
                $this->sender_type ?: 'غير محدد',
                $this->importance ?: 'غير محدد',
                $this->needs_reply ? 'نعم' : 'لا',
                $departments ? $departments . "\n" : '',
                $sections ? $sections . "\n" : '',
                (!$departments && !$sections) ? "لا توجد جهات\n" : ''
            );

            Tracking::create([
                'user_id' => Auth::id(),
                'page_name' => 'الكتب الواردة',
                'operation_type' => 'حذف',
                'operation_time' => now()->format('Y-m-d H:i:s'),
                'details' => $details
            ]);

            $year = date('Y', strtotime($Incomingbooks->book_date));
            Storage::deleteDirectory('public/Incomingbooks/' . $year . '/' . $Incomingbooks->book_number);

            $Incomingbooks->delete();

            // تحديث العداد بعد الحذف
            $this->updateEmailCounter();

            $this->reset();
            $this->dispatchBrowserEvent('success', [
                'message' => 'تم حذف البيانات بنجاح',
                'title' => 'الحذف'
            ]);
        }
    }

    public function showError()
    {
        $this->dispatchBrowserEvent('error', [
            'message' => 'لا يمكن حذف هذا الكتاب لوجود كتاب مرتبط اخر به',
            'title' => 'خطأ'
        ]);
    }

    public function printIncomingBook($id)
    {
        $incomingBook = Incomingbooks::find($id);

        if ($incomingBook) {
            // تحضير تفاصيل التتبع
            $departments = $incomingBook->Getdepartment()->pluck('department_name')
                ->map(fn($name) => "دائرة: " . $name)->join("\n");
            $sections = $incomingBook->Getsection()->pluck('section_name')
                ->map(fn($name) => "قسم: " . $name)->join("\n");

            $details = sprintf(
                "رقم الكتاب: %s\n" .
                    "تاريخ الكتاب: %s\n" .
                    "موضوع الكتاب: %s\n" .
                    "محتوى الكتاب: %s\n" .
                    "الكلمات المفتاحية: %s\n" .
                    "نوع الكتاب: %s\n" .
                    "نطاق الكتاب: %s\n" .
                    "درجة الأهمية: %s\n" .
                    "يحتاج لإجابة: %s\n" .
                    "الجهات:\n%s%s%s",
                $this->book_number ?: 'غير محدد',
                $this->book_date ?: 'غير محدد',
                $this->subject ?: 'غير محدد',
                $this->content ?: 'غير محدد',
                $this->keywords ?: 'غير محدد',
                $this->book_type ?: 'غير محدد',
                $this->sender_type ?: 'غير محدد',
                $this->importance ?: 'غير محدد',
                $this->needs_reply ? 'نعم' : 'لا',
                $departments ? $departments . "\n" : '',
                $sections ? $sections . "\n" : '',
                (!$departments && !$sections) ? "لا توجد جهات\n" : ''
            );

            Tracking::create([
                'user_id' => Auth::id(),
                'page_name' => 'الكتب الواردة',
                'operation_type' => 'طباعة',
                'operation_time' => now()->format('Y-m-d H:i:s'),
                'details' => $details
            ]);

            // تحضير مسار الملف للطباعة
            $year = date('Y', strtotime($incomingBook->book_date));
            $filePath = Storage::url('Incomingbooks/' . $year . '/' . $incomingBook->book_number . '/' . $incomingBook->attachment);

            // إرسال حدث JavaScript للطباعة
            $this->dispatchBrowserEvent('print-file', ['url' => $filePath]);
        }
    }

    // أضف هذه الدوال الجديدة
    public function updatedSelectAll($value)
    {
        if ($value) {
            // تعديل الاستعلام ليشمل جميع السجلات بدون تقسيم الصفحات
            $allIds = Incomingbooks::query()
                ->when($this->search['book_number'], function ($query) {
                    $query->where('book_number', 'LIKE', '%' . $this->search['book_number'] . '%');
                })
                ->when($this->search['book_date'], function ($query) {
                    $query->where('book_date', 'LIKE', '%' . $this->search['book_date'] . '%');
                })
                ->when($this->search['subject'], function ($query) {
                    $query->where('subject', 'LIKE', '%' . $this->search['subject'] . '%');
                })
                ->when($this->search['content'], function ($query) {
                    $query->where('content', 'LIKE', '%' . $this->search['content'] . '%');
                })
                ->when($this->search['related_book_id'], function ($query) {
                    $query->where('related_book_id', 'LIKE', '%' . $this->search['related_book_id'] . '%');
                })
                ->when($this->search['sender_type'], function ($query) {
                    $query->where('sender_type', 'LIKE', '%' . $this->search['sender_type'] . '%');
                })
                ->when($this->search['book_type'], function ($query) {
                    $query->where('book_type', 'LIKE', '%' . $this->search['book_type'] . '%');
                })
                ->when($this->search['sender_id'], function ($query) {
                    $query->where(function ($subQuery) {
                        $sectionIds = Sections::where('section_name', 'LIKE', '%' . $this->search['sender_id'] . '%')
                            ->pluck('id')
                            ->map(function ($id) {
                                return ['type' => 'sec', 'id' => $id];
                            })
                            ->toArray();

                        $departmentIds = Departments::where('department_name', 'LIKE', '%' . $this->search['sender_id'] . '%')
                            ->pluck('id')
                            ->map(function ($id) {
                                return ['type' => 'dep', 'id' => $id];
                            })
                            ->toArray();

                        $allIds = array_merge($sectionIds, $departmentIds);

                        if (!empty($allIds)) {
                            foreach ($allIds as $item) {
                                $jsonPattern = '%"type":"' . $item['type'] . '","id":' . $item['id'] . '%';
                                $subQuery->orWhere('sender_id', 'LIKE', $jsonPattern);
                            }
                        }
                    });
                })
                ->pluck('id')
                ->map(fn($id) => (string) $id)
                ->toArray();

            $this->selectedRows = $allIds;
        } else {
            $this->selectedRows = [];
        }
    }

    public function updatedSelectedRows($value)
    {
        $totalCount = Incomingbooks::query()
            ->when($this->search['book_number'], function ($query) {
                $query->where('book_number', 'LIKE', '%' . $this->search['book_number'] . '%');
            })
            ->when($this->search['book_date'], function ($query) {
                $query->where('book_date', 'LIKE', '%' . $this->search['book_date'] . '%');
            })
            ->when($this->search['subject'], function ($query) {
                $query->where('subject', 'LIKE', '%' . $this->search['subject'] . '%');
            })
            ->when($this->search['content'], function ($query) {
                $query->where('content', 'LIKE', '%' . $this->search['content'] . '%');
            })
            ->when($this->search['related_book_id'], function ($query) {
                $query->where('related_book_id', 'LIKE', '%' . $this->search['related_book_id'] . '%');
            })
            ->when($this->search['sender_type'], function ($query) {
                $query->where('sender_type', 'LIKE', '%' . $this->search['sender_type'] . '%');
            })
            ->when($this->search['book_type'], function ($query) {
                $query->where('book_type', 'LIKE', '%' . $this->search['book_type'] . '%');
            })
            ->when($this->search['sender_id'], function ($query) {
                $query->where(function ($subQuery) {
                    $sectionIds = Sections::where('section_name', 'LIKE', '%' . $this->search['sender_id'] . '%')
                        ->pluck('id')
                        ->map(function ($id) {
                            return ['type' => 'sec', 'id' => $id];
                        })
                        ->toArray();

                    $departmentIds = Departments::where('department_name', 'LIKE', '%' . $this->search['sender_id'] . '%')
                        ->pluck('id')
                        ->map(function ($id) {
                            return ['type' => 'dep', 'id' => $id];
                        })
                        ->toArray();

                    $allIds = array_merge($sectionIds, $departmentIds);

                    if (!empty($allIds)) {
                        foreach ($allIds as $item) {
                            $jsonPattern = '%"type":"' . $item['type'] . '","id":' . $item['id'] . '%';
                            $subQuery->orWhere('sender_id', 'LIKE', $jsonPattern);
                        }
                    }
                });
            })
            ->count();

        $this->selectAll = count($this->selectedRows) === $totalCount;
    }

    public function exportSelected()
    {
        if (empty($this->selectedRows)) {
            $this->dispatchBrowserEvent('error', [
                'title' => 'خطأ',
                'message' => 'الرجاء تحديد صف واحد على الأقل'
            ]);
            return;
        }

        // تسجيل تفاصيل الكتب المصدرة
        $books = Incomingbooks::whereIn('id', $this->selectedRows)->get();
        $exportDetails = "تم تصدير " . count($this->selectedRows) . " كتاب:\n";
        $exportDetails .= "======================\n";

        foreach ($books as $index => $book) {
            /* // تحضير الجهات
            $departments = $book->Getdepartment()->pluck('department_name')->map(function($name) {
                return "دائرة: " . $name;
            })->join("\n");

            $sections = $book->Getsection()->pluck('section_name')->map(function($name) {
                return "قسم: " . $name;
            })->join("\n"); */

            $exportDetails .= sprintf(
                /* "الكتاب رقم %d:\n" . */
                "رقم الكتاب: %s\n" .
                    "تاريخ الكتاب: %s\n" .
                    /* "موضوع الكتاب: %s\n" .
                "محتوى الكتاب: %s\n" .
                "الكلمات المفتاحية: %s\n" .
                "نوع الكتاب: %s\n" .
                "نطاق الكتاب: %s\n" .
                "درجة الأهمية: %s\n" .
                "يحتاج لإجابة: %s\n" .,
                 "الجهات:\n%s%s%s" . */
                    "======================\n",
                /* $index + 1, */
                $book->book_number ?: 'غير محدد',
                $book->book_date ?: 'غير محدد',
                /* $book->subject ?: 'غير محدد',
                $book->content ?: 'غير محدد',
                $book->keywords ?: 'غير محدد',
                $book->book_type ?: 'غير محدد',
                $book->sender_type ?: 'غير محدد',
                $book->importance ?: 'غير محدد',
                $book->needs_reply ? 'نعم' : 'لا',
                $departments ? $departments . "\n" : '',
                $sections ? $sections . "\n" : '',
                (!$departments && !$sections) ? "لا توجد جهات\n" : '' */
            );
        }

        // إنشاء سجل تتبع لعملية التصدير
        Tracking::create([
            'user_id' => Auth::id(),
            'page_name' => 'الكتب الواردة',
            'operation_type' => 'تصدير Excel',
            'operation_time' => now()->format('Y-m-d H:i:s'),
            'details' => $exportDetails
        ]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setRightToLeft(true);

        // تعيين العناوين
        $headers = [
            'رقم الكتاب',
            'تاريخ الكتاب',
            'موضوع الكتاب',
            'المتن',
            'نوع الكتاب',
            'نطاق الكتاب',
            'درجة الأهمية',
            'يحتاج لإجابة',
            'الجهات',
            'المرفقات'
        ];
        $sheet->fromArray([$headers], NULL, 'A1');

        // تنسيق العناوين
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
                'name' => 'Arial'
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4A6CF7']
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];
        $sheet->getStyle('A1:I1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // إضافة البيانات
        $row = 2;
        $books = Incomingbooks::whereIn('id', $this->selectedRows)->get();
        foreach ($books as $book) {
            // تحضير مسار الملف
            $year = date('Y', strtotime($book->book_date));
            $filePath = asset("storage/Incomingbooks/{$year}/{$book->book_number}/{$book->attachment}");

            // تجميع الجهات
            $departments = $book->Getdepartment()->pluck('department_name')->toArray();
            $sections = $book->Getsection()->pluck('section_name')->toArray();
            $entities = array_merge(
                array_map(fn($name) => "دائرة: {$name}", $departments),
                array_map(fn($name) => "قسم: {$name}", $sections)
            );
            $entitiesStr = implode("\n", $entities);

            $data = [
                $book->book_number,
                Carbon::parse($book->book_date)->format('Y/m/d'),
                $book->subject,
                $book->content,
                $book->book_type,
                $book->sender_type,
                $book->importance,
                $book->needs_reply ? 'نعم' : 'لا',
                $entitiesStr,
                $book->attachment ? 'HYPERLINK("' . $filePath . '","عرض المرفق")' // صيغة الارتباط التشعبي
                    : 'لا يوجد مرفق'
            ];
            $sheet->fromArray([$data], NULL, 'A' . $row);

            // إضافة الارتباط التشعبي للمرفق
            if ($book->attachment) {
                $sheet->getCell('I' . $row)->getHyperlink()->setUrl($filePath);
                $sheet->getStyle('I' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE));
                $sheet->getStyle('I' . $row)->getFont()->setUnderline(true);
            }

            $row++;
        }

        // تنسيق البيانات
        $dataRange = 'A2:I' . ($row - 1);
        $dataStyle = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];
        $sheet->getStyle($dataRange)->applyFromArray($dataStyle);

        // تلوين الصفوف بالتناوب
        for ($i = 2; $i < $row; $i++) {
            if ($i % 2 == 0) {
                $sheet->getStyle('A' . $i . ':I' . $i)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->setStartColor(new \PhpOffice\PhpSpreadsheet\Style\Color('F8F9FA'));
            }
        }

        // تعيين عرض الأعمدة
        foreach (range('A', 'I') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // تجميد الصف الأول
        $sheet->freezePane('A2');

        $fileName = 'incomingbooks_' . date('Y-m-d_H-i-s') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        $path = storage_path('app/public/exports');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $fullPath = $path . '/' . $fileName;
        $writer->save($fullPath);

        return response()->download($fullPath)->deleteFileAfterSend();
    }

    // دالة مساعدة للحصول على تفاصيل الجهات المرسلة
    private function getSenderDetails($type)
    {
        $processedIds = array_map(function ($id) {
            $parts = explode('_', $id);
            return ['type' => $parts[0], 'id' => intval($parts[1])];
        }, $this->sender_id);

        $ids = collect($processedIds)
            ->filter(fn($item) => $item['type'] === $type)
            ->pluck('id');

        if ($type === 'dep') {
            return Departments::whereIn('id', $ids)
                ->pluck('department_name')
                ->map(fn($name) => "دائرة: " . $name)
                ->join("\n");
        } else {
            return Sections::whereIn('id', $ids)
                ->pluck('section_name')
                ->map(fn($name) => "قسم: " . $name)
                ->join("\n");
        }
    }
}
