<?php

namespace App\Http\Livewire\Incomingbooks;

use Carbon\Carbon;


use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use App\Models\Sections\Sections;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Emaillists\Emaillists;
use App\Mail\IncomingBookNotification;
use App\Models\Departments\Departments;
use Illuminate\Support\Facades\Storage;
use App\Models\Incomingbooks\Incomingbooks;

class Incomingbook extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $Incomingbooks = [];
    public $departments = [];
    public $sections = [];
    public $sender_id = [];
    public $sender_type = '';
    public $Incomingbook, $IncomingbookId;
    public $book_number, $book_date, $subject, $content, $keywords, $related_book_id, $attachment, $book_type, $importance;
    public $filePreview, $previewIncomingbookImage;
    public $search = ['book_number' => '', 'book_date' => '', 'subject' => '', 'content' => '', 'related_book_id' => '', 'sender_type' => '', 'sender_id' => '', 'book_type' => '', 'importance' => ''];
    public $sendEmail = false;
    public $todayEmailCount = 0;
    public $remainingEmails = 450;

    protected $listeners = [
        'GetSenderId',
        'GetDepAndSec',
        'showIncomingbookbook' => 'handleBookDateUpdated',
        'showError',
    ];

    public function hydrate()
    {
        $this->emit('select2');
        $this->emit('flatpickr');
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
        if (in_array($key, ['book_number', 'subject', 'content', 'related_book_id', 'sender_type', 'sender_id', 'book_type'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $this->updateEmailCounter();

        $book_numberSearch = '%' . $this->search['book_number'] . '%';
        $book_dateSearch = '%' . $this->search['book_date'] . '%';
        $subjectSearch = '%' . $this->search['subject'] . '%';
        $contentSearch = '%' . $this->search['content'] . '%';
        $related_book_idSearch = '%' . $this->search['related_book_id'] . '%';
        $sender_typeSearch = '%' . $this->search['sender_type'] . '%';
        $sender_idSearch = '%' . $this->search['sender_id'] . '%';
        $book_typeSearch = '%' . $this->search['book_type'] . '%';

        $Incomingbooks = Incomingbooks::query()
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
        $this->Incomingbooks = collect($Incomingbooks->items());

        $incomingbooks = Incomingbooks::all();

        return view('livewire.incomingbooks.incomingbook', [
            'Departments' => $Incomingbooks,
            'links' => $links,
            'incomingbooks' => $incomingbooks
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

    public function updatedIncomingbookImage()
    {
        $this->validate([
            'attachment' => 'required|file|mimes:jpeg,png,jpg,pdf|max:20480',
        ], [
            'attachment.required' => 'ملف الكتاب مطلوب.',
            'attachment.max' => 'يجب ألا يزيد حجم ملف الكتاب عن 20 ميجا.',
            'attachment.mimes' => 'الملف ليس صورة أو PDF',
        ]);
        $this->filePreview = $this->attachment->temporaryUrl();
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
        $this->filePreview = $this->attachment->temporaryUrl();
    }

    public function AddIncomingbookModalShow()
    {
        $this->reset('book_number', 'book_date', 'subject', 'content', 'keywords', 'related_book_id', 'sender_type', 'sender_id', 'attachment');
        $this->resetValidation();
        $this->dispatchBrowserEvent('IncomingbookModalShow');
    }

    public function GetIncomingbook($IncomingbookId)
    {
        $this->reset('book_number', 'book_date', 'subject', 'content', 'keywords', 'related_book_id', 'sender_type', 'sender_id', 'attachment');
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

        if ($this->Incomingbook->attachment) {
            $year = date('Y', strtotime($this->Incomingbook->book_date));
            $this->previewIncomingbookImage = Storage::url('public/Incomingbooks/' . $year . '/' . $this->book_number . '/' . $this->Incomingbook->attachment);
        } else {
            $this->previewIncomingbookImage = null;
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
            'book_type.required' => 'حقل نوع الكتاب مطلوب',
            'book_type.in' => 'قيمة نوع الكتاب غير صحيحة',
            'importance.required' => 'حقل درجة الأهمية مطلوب',
            'importance.in' => 'قيمة درجة الأهمية غير صحيحة',
        ]);

        $year = date('Y', strtotime($formatted_date));
        $this->attachment->store('public/Incomingbooks/' . $year . '/' . $this->book_number);

        // معالجة sender_id قبل الحفظ
        $processed_sender_ids = array_map(function ($id) {
            $parts = explode('_', $id);
            return [
                'type' => $parts[0],
                'id' => intval($parts[1])
            ];
        }, $this->sender_id);

        $incomingBook = Incomingbooks::create([
            'user_id' => Auth::User()->id,
            'book_number' => $this->book_number,
            'book_date' => $formatted_date,
            'subject' => $this->subject,
            'content' => $this->content,
            'keywords' => $this->keywords,
            'related_book_id' => $this->related_book_id,
            'sender_type' => $this->sender_type,
            'sender_id' => json_encode($processed_sender_ids),
            'attachment' => $this->attachment->hashName(),
            'book_type' => $this->book_type,
            'importance' => $this->importance,
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
            ];

            $emailResult = $this->sendEmailNotification($processed_sender_ids, $bookData);
            $this->dispatchBrowserEvent('showDelayedMessage', [
                'message' => 'تم ارسال نسخة من الكتاب عبر البريد الالكتروني',
                'title' => 'البريد الالكتروني'
            ]);

            $this->incrementEmailCounter($emailCount);
        }

        $this->reset('book_number', 'book_date', 'subject', 'content', 'keywords', 'related_book_id', 'sender_type', 'sender_id', 'attachment', 'filePreview');

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

        // معالجة sender_id قبل التحديث
        $processed_sender_ids = array_map(function ($id) {
            $parts = explode('_', $id);
            return [
                'type' => $parts[0],
                'id' => intval($parts[1])
            ];
        }, $this->sender_id);

        $Incomingbooks->update([
            'user_id' => Auth::User()->id,
            'book_number' => $this->book_number,
            'book_date' => $formatted_date,
            'subject' => $this->subject,
            'content' => $this->content,
            'keywords' => $this->keywords,
            'related_book_id' => $this->related_book_id,
            'sender_type' => $this->sender_type,
            'sender_id' => json_encode($processed_sender_ids),
            'book_type' => $this->book_type,
            'importance' => $this->importance,
        ]);

        $this->reset('book_number', 'book_date', 'subject', 'content', 'keywords', 'related_book_id', 'sender_type', 'sender_id', 'attachment', 'filePreview');
        $this->dispatchBrowserEvent('success', [
            'message' => 'تم التعديل بنجاح',
            'title' => 'تعديل'
        ]);
    }

    public function destroy()
    {
        $Incomingbooks = Incomingbooks::find($this->IncomingbookId);

        if ($Incomingbooks) {
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
}
