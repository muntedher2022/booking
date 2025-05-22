<?php

namespace App\Http\Livewire\Incomingbooks;

use Livewire\Component;


use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\Departments\Departments;
use Illuminate\Support\Facades\Storage;
use App\Models\Incomingbooks\Incomingbooks;
use Carbon\Carbon;

class Incomingbook extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $Incomingbooks = [];
    public $departments = [];
    public $sender_id = [];
    public $sender_type = '';
    public $Incomingbook, $IncomingbookId;
    public $book_number, $book_date, $subject, $content, $keywords, $related_book_id, $attachment, $book_type, $importance;
    public $filePreview, $previewIncomingbookImage;
    public $search = ['book_number' => '', 'book_date' => '', 'subject' => '', 'content' => '', 'related_book_id' => '', 'sender_type' => '', 'sender_id' => '', 'book_type' => '', 'importance' => ''];

    protected $listeners = [
        'GetSenderId',
        'GetDepAndSec',
        'showIncomingbookbook' => 'handleBookDateUpdated',
        'showError',  // إضافة المستمع الجديد
    ];

    public function hydrate()
    {
        $this->emit('select2');
        $this->emit('flatpickr');
    }

    public function mount()
    {
        $this->departments = Departments::all();
    }

    public function handleBookDateUpdated($value)
    {
        $this->search['book_date'] = $value;
        $this->resetPage();
    }

    public function updatedSearch($value, $key)
    {
        if (in_array($key, ['book_number', 'subject', 'content', 'related_book_id', 'sender_type', 'sender_id'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $book_numberSearch = '%' . $this->search['book_number'] . '%';
        $book_dateSearch = '%' . $this->search['book_date'] . '%';
        $subjectSearch = '%' . $this->search['subject'] . '%';
        $contentSearch = '%' . $this->search['content'] . '%';
        $related_book_idSearch = '%' . $this->search['related_book_id'] . '%';
        $sender_typeSearch = '%' . $this->search['sender_type'] . '%';
        $sender_idSearch = '%' . $this->search['sender_id'] . '%';

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
            ->when($this->search['sender_id'], function ($query) use ($sender_idSearch) {
                $query->where(function ($subQuery) use ($sender_idSearch) {
                    $departmentIds = Departments::where('department_name', 'LIKE', '%' . $sender_idSearch . '%')
                        ->pluck('id')
                        ->toArray();

                    $subQuery->where(function ($q) use ($departmentIds) {
                        foreach ($departmentIds as $id) {
                            $q->orWhereJsonContains('sender_id', (string) $id);
                        }
                    });
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
            'attachment' => 'required|file|mimes:jpeg,png,jpg,pdf|max:1024',
        ], [
            'attachment.required' => 'ملف الكتاب الوارد مطلوب.',
            'attachment.max' => 'يجب ألا يزيد حجم ملف الكتاب الوارد عن 1024 كيلوبايت.',
            'attachment.mimes' => 'الملف ليس صورة أو PDF',
        ]);
        $this->filePreview = $this->attachment->temporaryUrl();
    }

    public function updatedAttachment()
    {
        $this->validate([
            'attachment' => 'required|file|mimes:jpeg,png,jpg,pdf|max:1024',
        ], [
            'attachment.required' => 'ملف الكتاب الوارد مطلوب.',
            'attachment.max' => 'يجب ألا يزيد حجم ملف الكتاب الوارد عن 1024 كيلوبايت.',
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

    private function formatDate($date)
    {
        if (!$date) return null;
        try {
            return Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
        } catch (\Exception $e) {
            try {
                return Carbon::parse($date)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }
    }

    public function store()
    {
        $this->resetValidation();
        $this->validate([
            'book_number' => [
                'required',
                Rule::unique('incomingbooks')->where(function ($query) {
                    return $query->whereYear('book_date', date('Y', strtotime($this->book_date)));
                }),
            ],
            'book_date' => 'required',
            'subject' => 'required',
            //'content' => 'required',
            //'keywords' => 'required',
            //'related_book_id' => 'required',
            'sender_type' => 'required',
            'sender_id' => 'required|array',
            'sender_id.*' => 'required|integer',
            'attachment' => 'required|file|mimes:jpeg,png,jpg,pdf|max:1024',
            'book_type' => 'required|in:صادر,وارد',
            'importance' => 'required|in:عادي,عاجل,سري,سري للغاية',
        ], [
            'book_number.required' => 'حقل رقم الكتاب الوارد مطلوب',
            'book_number.unique' => 'رقم الكتاب الوارد مكرر خلال السنة الحالية',
            'book_date.required' => 'حقل تاريخ الكتاب مطلوب',
            'subject.required' => 'حقل موضوع الكتاب مطلوب',
            //'content.required' => 'حقل جزء من المتن مطلوب',
            //'keywords.required' => 'حقل كلمات مفتاحية مطلوب',
            //'related_book_id.required' => 'حقل رقم الكتاب المرتبط مطلوب',
            'sender_type.required' => 'حقل نطاق الكتاب مطلوب',
            'sender_id.required' => 'حقل الجهة المرسلة للكتاب مطلوب',
            'sender_id.array' => 'يجب اختيار جهة واحدة على الأقل',
            'sender_id.*.integer' => 'يجب أن تكون القيم المختارة صحيحة',
            'attachment.required' => 'ملف الكتاب الوارد مطلوب',
            'attachment.max' => 'يجب ألا يزيد حجم ملف السند العقاري عن 1024 كيلوبايت.',
            'attachment.mimes' => 'الملف ليس صورة أو PDF',
            'book_type.required' => 'حقل نوع الكتاب مطلوب',
            'book_type.in' => 'قيمة نوع الكتاب غير صحيحة',
            'importance.required' => 'حقل درجة الأهمية مطلوب',
            'importance.in' => 'قيمة درجة الأهمية غير صحيحة',
        ]);

        $year = date('Y', strtotime($this->formatDate($this->book_date)));

        $this->attachment->store('public/Incomingbooks/' . $year . '/' . $this->book_number);

        Incomingbooks::create([
            'user_id' => Auth::User()->id,
            'book_number' => $this->book_number,
            'book_date' => $this->formatDate($this->book_date),
            'subject' => $this->subject,
            'content' => $this->content,
            'keywords' => $this->keywords,
            'related_book_id' => $this->related_book_id,
            'sender_type' => $this->sender_type,
            'sender_id' => json_encode($this->sender_id),
            'attachment' => $this->attachment->hashName(),
            'book_type' => $this->book_type,
            'importance' => $this->importance,
        ]);

        $this->reset('book_number', 'book_date', 'subject', 'content', 'keywords', 'related_book_id', 'sender_type', 'sender_id', 'attachment', 'filePreview');
        $this->dispatchBrowserEvent('success', [
            'message' => 'تم الاضافه بنجاح',
            'title' => 'اضافه'
        ]);
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
        $this->sender_id = $this->Incomingbook->sender_id ? json_decode($this->Incomingbook->sender_id, true) : [];
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
                Rule::unique('incomingbooks')->where(function ($query) {
                    return $query->whereYear('book_date', date('Y', strtotime($this->book_date)));
                })->ignore($this->IncomingbookId),
            ],
            'book_date' => 'required',
            'subject' => 'required',
            //'content' => 'required',
            //'keywords' => 'required',
            //'related_book_id' => 'required',
            'sender_type' => 'required',
            'sender_id' => 'required|array',
            'sender_id.*' => 'required|integer',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:1024',
            'book_type' => 'required|in:صادر,وارد',
            'importance' => 'required|in:عادي,عاجل,سري,سري للغاية',
        ], [
            'book_number.required' => 'حقل رقم الكتاب الوارد مطلوب',
            'book_number.unique' => 'رقم الكتاب الوارد مكرر خلال السنة الحالية',
            'book_date.required' => 'حقل تاريخ الكتاب مطلوب',
            'subject.required' => 'حقل موضوع الكتاب مطلوب',
            //'content.required' => 'حقل جزء من المتن مطلوب',
            //'keywords.required' => 'حقل كلمات مفتاحية مطلوب',
            //'related_book_id.required' => 'حقل رقم الكتاب المرتبط مطلوب',
            'sender_type.required' => 'حقل نطاق الكتاب مطلوب',
            'sender_id.required' => 'حقل الجهة المرسلة للكتاب مطلوب',
            'sender_id.array' => 'يجب اختيار جهة واحدة على الأقل',
            'sender_id.*.integer' => 'يجب أن تكون القيم المختارة صحيحة',
            'attachment.mimes' => 'الملف ليس صورة أو PDF',
            'attachment.max' => 'يجب ألا يزيد حجم ملف السند العقاري عن 1024 كيلوبايت.',
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

        $Incomingbooks->update([
            'user_id' => Auth::User()->id,
            'book_number' => $this->book_number,
            'book_date' => $formatted_date,
            'subject' => $this->subject,
            'content' => $this->content,
            'keywords' => $this->keywords,
            'related_book_id' => $this->related_book_id,
            'sender_type' => $this->sender_type,
            'sender_id' => json_encode($this->sender_id),
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
            'message' => 'لا يمكن حذف هذا الكتاب لوجود كتاب مرتبط به',
            'title' => 'خطأ'
        ]);
    }
}
