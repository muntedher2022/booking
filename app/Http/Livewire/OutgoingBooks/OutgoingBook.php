<?php

namespace App\Http\Livewire\Outgoingbooks;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\Departments\Departments;
use Illuminate\Support\Facades\Storage;
use App\Models\Incomingbooks\Incomingbooks;
use App\Models\Outgoingbooks\Outgoingbooks;

class Outgoingbook extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $Outgoingbooks = [];
    public $departments = [];
    public $incomingbooks = [];
    public $recipient_id = [];
    public $recipient_type = '';
    public $Outgoingbook, $OutgoingbookId;
    public $book_number, $book_date, $subject, $content, $keywords, $related_book_id, $attachment;
    public $filePreview, $previewOutgoingbookImage;
    public $search = ['book_number' => '', 'book_date' => '', 'subject' => '', 'content' => '', 'related_book_id' => '', 'recipient_type' => '', 'recipient_id' => ''];

    protected $listeners = [
        'GetRecipientId',
        'GetDepAndSec',
        'showOutgoingbookbook_date' => 'handleBookDateUpdated',
    ];

    public function hydrate()
    {
        $this->emit('select2');
        $this->emit('flatpickr');
    }

    public function mount()
    {
        $this->departments = Departments::all();
        $this->incomingbooks = Incomingbooks::all();
    }

    public function handleBookDateUpdated($value)
    {
        $this->search['book_date'] = $value;
        $this->resetPage();
    }

    public function updatedSearch($value, $key)
    {
        if (in_array($key, ['book_number', 'subject', 'content', 'related_book_id', 'recipient_type', 'recipient_id'])) {
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
        $recipient_typeSearch = '%' . $this->search['recipient_type'] . '%';
        $recipient_idSearch = '%' . $this->search['recipient_id'] . '%';

        $Outgoingbooks = Outgoingbooks::query()
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
                $query->whereHas('Getincomingbook', function ($q) use ($related_book_idSearch) {
                    $q->where('book_number', 'LIKE', $related_book_idSearch);
                });
            })
            ->when($this->search['recipient_type'], function ($query) use ($recipient_typeSearch) {
                $query->where('recipient_type', 'LIKE', $recipient_typeSearch);
            })
            ->when($this->search['recipient_id'], function ($query) use ($recipient_idSearch) {
                $query->where(function ($subQuery) use ($recipient_idSearch) {
                    $departmentIds = Departments::where('department_name', 'LIKE', $recipient_idSearch)
                        ->pluck('id')
                        ->toArray();

                    $subQuery->where(function ($q) use ($departmentIds) {
                        foreach ($departmentIds as $id) {
                            $q->orWhereJsonContains('recipient_id', (string) $id);
                        }
                    });
                });
            })
            ->orderBy('id', 'ASC')
            ->paginate(10);

        $links = $Outgoingbooks;
        $this->Outgoingbooks = collect($Outgoingbooks->items());

        return view('livewire.outgoingbooks.outgoingbook', [
            'Departments' => $Outgoingbooks,
            'links' => $links
        ]);
    }


    public function GetDepAndSec($recipient_id)
    {
        if ($recipient_id) {
            $this->recipient_id = $recipient_id;
        } else {
            $this->recipient_id = null;
        }
    }

    public function GetRecipientId($RelatedBookIdID)
    {
        $related_book_id = Incomingbooks::find($RelatedBookIdID);
        if ($related_book_id) {
            $this->related_book_id = $RelatedBookIdID;
        } else {
            $this->related_book_id = null;
        }
    }

    public function updatedRecipientType($value)
    {
        $this->reset('recipient_id');
        $this->dispatchBrowserEvent('initAddSelect2', [
            'selector' => '#addOutgoingbookrecipient_id',
            'values' => $this->recipient_id
        ]);

        $this->dispatchBrowserEvent('initEditSelect2', [
            'selector' => '#editOutgoingbookrecipient_id',
            'values' => $this->recipient_id
        ]);
    }

    public function updatedOutgoingbookImage()
    {
        $this->validate([
            'attachment' => 'required|file|mimes:jpeg,png,jpg,pdf|max:1024',
        ], [
            'attachment.required' => 'ملف الكتاب الصادر مطلوب.',
            'attachment.max' => 'يجب ألا يزيد حجم ملف الكتاب الصادر عن 1024 كيلوبايت.',
            'attachment.mimes' => 'الملف ليس صورة أو PDF',
        ]);
        $this->filePreview = $this->attachment->temporaryUrl();
    }

    public function updatedAttachment()
    {
        $this->validate([
            'attachment' => 'required|file|mimes:jpeg,png,jpg,pdf|max:1024',
        ], [
            'attachment.required' => 'ملف الكتاب الصادر مطلوب.',
            'attachment.max' => 'يجب ألا يزيد حجم ملف الكتاب الصادر عن 1024 كيلوبايت.',
            'attachment.mimes' => 'الملف ليس صورة أو PDF',
        ]);
        $this->filePreview = $this->attachment->temporaryUrl();
    }


    public function AddOutgoingbookModalShow()
    {
        $this->reset('book_number', 'book_date', 'subject', 'content', 'keywords', 'related_book_id', 'recipient_type', 'recipient_id', 'attachment');
        $this->resetValidation();
        $this->dispatchBrowserEvent('OutgoingbookModalShow');
    }

    public function store()
    {
        $this->resetValidation();
        $this->validate([
            'book_number' => [
                'required',
                Rule::unique('outgoingbooks')->where(function ($query) {
                    return $query->whereYear('book_date', date('Y', strtotime($this->book_date)));
                }),
            ],
            'book_date' => 'required',
            'subject' => 'required',
            //'content' => 'required',
            //'keywords' => 'required',
            //'related_book_id' => 'required',
            'recipient_type' => 'required',
            'recipient_id' => 'required|array',
            'recipient_id.*' => 'required|integer',
            'attachment' => 'required|file|mimes:jpeg,png,jpg,pdf|max:1024',
        ], [
            'book_number.required' => 'حقل رقم الكتاب الصادر مطلوب',
            'book_number.unique' => 'رقم الكتاب الصادر مكرر خلال السنة الحالية',
            'book_date.required' => 'حقل تاريخ الكتاب مطلوب',
            'subject.required' => 'حقل موضوع الكتاب مطلوب',
            //'content.required' => 'حقل جزء من المتن مطلوب',
            //'keywords.required' => 'حقل كلمات مفتاحية مطلوب',
            //'related_book_id.required' => 'حقل رقم الكتاب المرتبط مطلوب',
            'recipient_type.required' => 'حقل نوع الكتاب داخلي او خارجي مطلوب',
            'recipient_id.required' => 'حقل الجهة المعنون اليها الكتاب مطلوب',
            'recipient_id.array' => 'يجب اختيار جهة واحدة على الأقل',
            'recipient_id.*.integer' => 'يجب أن تكون القيم المختارة صحيحة',
            'attachment.required' => 'ملف الكتاب الصادر مطلوب',
            'attachment.max' => 'يجب ألا يزيد حجم ملف السند العقاري عن 1024 كيلوبايت.',
            'attachment.mimes' => 'الملف ليس صورة أو PDF',
        ]);

        $year = date('Y', strtotime($this->book_date));

        $this->attachment->store('public/Outgoingbooks/' . $year . '/' . $this->book_number);

        Outgoingbooks::create([
            'user_id' => Auth::User()->id,
            'book_number' => $this->book_number,
            'book_date' => $this->book_date,
            'subject' => $this->subject,
            'content' => $this->content,
            'keywords' => $this->keywords,
            'related_book_id' => $this->related_book_id,
            'recipient_type' => $this->recipient_type,
            'recipient_id' => json_encode($this->recipient_id),
            'attachment' => $this->attachment->hashName(),
        ]);

        $this->reset('book_number', 'book_date', 'subject', 'content', 'keywords', 'related_book_id', 'recipient_type', 'recipient_id', 'attachment', 'filePreview');
        $this->dispatchBrowserEvent('success', [
            'message' => 'تم الاضافه بنجاح',
            'title' => 'اضافه'
        ]);
    }

    public function GetOutgoingbook($OutgoingbookId)
    {
        $this->reset('book_number', 'book_date', 'subject', 'content', 'keywords', 'related_book_id', 'recipient_type', 'recipient_id', 'attachment');
        $this->resetValidation();
        $this->dispatchBrowserEvent('editoutgoingbookModal');

        $this->Outgoingbook = Outgoingbooks::find($OutgoingbookId);
        $this->OutgoingbookId = $this->Outgoingbook->id;
        $this->book_number = $this->Outgoingbook->book_number;
        $this->book_date = $this->Outgoingbook->book_date;
        $this->subject = $this->Outgoingbook->subject;
        $this->content = $this->Outgoingbook->content;
        $this->keywords = $this->Outgoingbook->keywords;
        $this->related_book_id = $this->Outgoingbook->related_book_id;
        $this->recipient_type = $this->Outgoingbook->recipient_type;
        $this->recipient_id = $this->Outgoingbook->recipient_id ? json_decode($this->Outgoingbook->recipient_id, true) : [];

        if ($this->Outgoingbook->attachment) {
            $year = date('Y', strtotime($this->Outgoingbook->book_date));
            $this->previewOutgoingbookImage = Storage::url('public/Outgoingbooks/' . $year . '/' . $this->book_number . '/' . $this->Outgoingbook->attachment);
        } else {
            $this->previewOutgoingbookImage = null;
        }

        $this->dispatchBrowserEvent('initEditSelect2', [
            'selector' => '#editOutgoingbookrecipient_id',
            'values' => $this->recipient_id
        ]);
    }

    public function update()
    {
        $this->resetValidation();
        $this->validate([
            'book_number' => [
                'required',
                Rule::unique('outgoingbooks')->where(function ($query) {
                    return $query->whereYear('book_date', date('Y', strtotime($this->book_date)));
                })->ignore($this->OutgoingbookId),
            ],
            'book_date' => 'required',
            'subject' => 'required',
            //'content' => 'required',
            //'keywords' => 'required',
            //'related_book_id' => 'required',
            'recipient_type' => 'required',
            'recipient_id' => 'required|array',
            'recipient_id.*' => 'required|integer',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:1024',
        ], [
            'book_number.required' => 'حقل رقم الكتاب الصادر مطلوب',
            'book_number.unique' => 'رقم الكتاب الصادر مكرر خلال السنة الحالية',
            'book_date.required' => 'حقل تاريخ الكتاب مطلوب',
            'subject.required' => 'حقل موضوع الكتاب مطلوب',
            //'content.required' => 'حقل جزء من المتن مطلوب',
            //'keywords.required' => 'حقل كلمات مفتاحية مطلوب',
            //'related_book_id.required' => 'حقل رقم الكتاب المرتبط مطلوب',
            'recipient_type.required' => 'حقل نوع الكتاب داخلي او خارجي مطلوب',
            'recipient_id.required' => 'حقل الجهة المعنون اليها الكتاب مطلوب',
            'recipient_id.array' => 'يجب اختيار جهة واحدة على الأقل',
            'recipient_id.*.integer' => 'يجب أن تكون القيم المختارة صحيحة',
            'attachment.mimes' => 'الملف ليس صورة أو PDF',
            'attachment.max' => 'يجب ألا يزيد حجم ملف السند العقاري عن 1024 كيلوبايت.',
        ]);

        $Outgoingbooks = Outgoingbooks::find($this->OutgoingbookId);

        $year = date('Y', strtotime($this->book_date));

        if ($this->attachment) {
            if ($Outgoingbooks->attachment) {
                Storage::delete('public/Outgoingbooks/' . $year . '/' . $this->book_number . '/' . $Outgoingbooks->attachment);
            }
            $filePath = $this->attachment->store('public/Outgoingbooks/' . $year . '/' . $this->book_number);
            $Outgoingbooks->attachment = basename($filePath);
        }

        $Outgoingbooks->update([
            'user_id' => Auth::User()->id,
            'book_number' => $this->book_number,
            'book_date' => $this->book_date,
            'subject' => $this->subject,
            'content' => $this->content,
            'keywords' => $this->keywords,
            'related_book_id' => $this->related_book_id,
            'recipient_type' => $this->recipient_type,
            'recipient_id' => json_encode($this->recipient_id),
        ]);

        $this->reset('book_number', 'book_date', 'subject', 'content', 'keywords', 'related_book_id', 'recipient_type', 'recipient_id', 'attachment', 'filePreview');
        $this->dispatchBrowserEvent('success', [
            'message' => 'تم التعديل بنجاح',
            'title' => 'تعديل'
        ]);
    }
    public function destroy()
    {
        $Outgoingbooks = Outgoingbooks::find($this->OutgoingbookId);

        if ($Outgoingbooks) {
            $year = date('Y', strtotime($Outgoingbooks->book_date));
            Storage::deleteDirectory('public/Outgoingbooks/' . $year . '/' . $Outgoingbooks->book_number);

            $Outgoingbooks->delete();

            $this->reset();
            $this->dispatchBrowserEvent('success', [
                'message' => 'تم حذف البيانات بنجاح',
                'title' => 'الحذف'
            ]);
        }
    }
}
