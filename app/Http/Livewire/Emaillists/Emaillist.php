<?php

namespace App\Http\Livewire\Emaillists;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sections\Sections;
use App\Models\Departments\Departments;
use App\Models\Emaillists\Emaillists;
use Illuminate\Support\Facades\Auth;

class Emaillist extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $type = 'section';
    public $departments = [];
    public $Emaillists = [];
    public $sections = [];
    public $emaillistSearch, $emaillist, $emaillistId;
    public $department, $email, $notes;
    public $search = ['department' => '', 'email' => '', 'notes' => ''];

    protected $listeners = [
        'SelectDepartment',
    ];
    public function hydrate()
    {
        $this->emit('select2');
    }
    public function mount()
    {
        $this->sections = Sections::all();
        $this->departments = Departments::all();
    }

    public function updatedType()
    {
        $this->department = '';
    }

    public function SelectDepartment($DepartmentID)
    {
        $department = Sections::find($DepartmentID);
        if ($department) {
            $this->department = $DepartmentID;
        } else {
            $this->department = null;
        }
    }


    public function render()
    {
        $departmentSearch = '%' . $this->search['department'] . '%';
        $emailSearch = '%' . $this->search['email'] . '%';
        $notesSearch = '%' . $this->search['notes'] . '%';

        $Emaillists = Emaillists::query()
            ->when($this->search['department'], function ($query) use ($departmentSearch) {
                $query->where('department', 'LIKE', $departmentSearch);
            })
            ->when($this->search['email'], function ($query) use ($emailSearch) {
                $query->where('email', 'LIKE', $emailSearch);
            })
            ->when($this->search['notes'], function ($query) use ($notesSearch) {
                $query->where('notes', 'LIKE', $notesSearch);
            })

            ->orderBy('id', 'ASC')
            ->paginate(10);
        $links = $Emaillists;
        $this->Emaillists = collect($Emaillists->items());

        return view('livewire.emaillists.emaillist', [
            'Emaillists' => $Emaillists,
            'links' => $links
        ]);
    }

    public function AddemaillistModalShow()
    {
        $this->reset(['department', 'email', 'notes']);
        $this->resetValidation();
        // إعادة تحميل البيانات
        $this->mount();

        $this->dispatchBrowserEvent('emaillistModalShow');
    }

    public function store()
    {
        $this->resetValidation();
        $this->validate([
            'type' => 'required|in:section,department',
            'department' => 'required',
            'email' => 'required|email|unique:emaillists,email',
        ], [
            'type.required' => 'يرجى تحديد قسم أو دائرة',
            'department.required' => 'يرجى اختيار القسم / الدائرة',
            'email.required' => 'يرجى إدخال البريد الإلكتروني',
            'email.email' => 'يرجى إدخال بريد إلكتروني صحيح',
            'email.unique' => 'هذا البريد الإلكتروني مسجل مسبقاً'
        ]);

        Emaillists::create([
            'user_id' => Auth::id(),
            'type' => $this->type,
            'department' => $this->department,
            'email' => $this->email,
            'notes' => $this->notes,
        ]);

        // إعادة تحميل البيانات بعد الإضافة
        $this->mount();
        $this->reset();
        $this->dispatchBrowserEvent('success', [
            'message' => 'تم الاضافه بنجاح',
            'title' => 'اضافه'
        ]);
    }

    public function Getemaillist($emaillistId)
    {
        $this->resetValidation();
        $this->emaillist = Emaillists::find($emaillistId);
        $this->emaillistId = $this->emaillist->id;
        $this->type = $this->emaillist->type;
        $this->department = $this->emaillist->department;
        $this->email = $this->emaillist->email;
        $this->notes = $this->emaillist->notes;
    }

    public function update()
    {
        $this->resetValidation();
        $this->validate([
            'type' => 'required|in:section,department',
            'department' => 'required',
            'email' => 'required|email|unique:emaillists,email,' . $this->emaillistId,
        ], [
            'type.required' => 'يرجى تحديد قسم أو دائرة',
            'department.required' => 'يرجى اختيار القسم / الدائرة',
            'email.required' => 'يرجى إدخال البريد الإلكتروني',
            'email.email' => 'يرجى إدخال بريد إلكتروني صحيح',
            'email.unique' => 'هذا البريد الإلكتروني مسجل مسبقاً'
        ]);

        $Emaillists = Emaillists::find($this->emaillistId);
        $Emaillists->update([
            'user_id' => Auth::id(),
            'type' => $this->type,
            'department' => $this->department,
            'email' => $this->email,
            'notes' => $this->notes,
        ]);
        $this->reset(['department', 'email', 'notes']);
        $this->dispatchBrowserEvent('success', [
            'message' => 'تم التعديل بنجاح',
            'title' => 'تعديل'
        ]);
    }

    public function destroy()
    {
        $Emaillists = Emaillists::find($this->emaillistId);
        if ($Emaillists) {
            $Emaillists->delete();
            $this->reset();
            $this->dispatchBrowserEvent('success', [
                'message' => 'تم حذف البيانات بنجاح',
                'title' => 'الحذف'
            ]);
        }
    }
}
