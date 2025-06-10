<?php

namespace App\Http\Livewire\Emaillists;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sections\Sections;
use App\Models\Tracking\Tracking;
use Illuminate\Support\Facades\Auth;
use App\Models\Emaillists\Emaillists;
use App\Models\Departments\Departments;

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
        'refreshData' => '$refresh'  // إضافة هذا السطر
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
        // التحقق من القيمة الحالية للـ department
        if ($this->department) {
            if ($this->type == 'section') {
                // التحقق من وجود القيمة في جدول الأقسام
                $exists = Sections::where('id', $this->department)->exists();
            } else {
                // التحقق من وجود القيمة في جدول الدوائر
                $exists = Departments::where('id', $this->department)->exists();
            }

            // إذا لم تكن القيمة موجودة في الجدول الجديد، قم بتصفير القيمة
            if (!$exists) {
                $this->department = '';
            }
        }

        $this->emit('select2');
    }

    public function SelectDepartment($DepartmentID)
    {
        if ($this->type == 'section') {
            $exists = Sections::find($DepartmentID);
        } else {
            $exists = Departments::find($DepartmentID);
        }

        if ($exists) {
            $this->department = $DepartmentID;
        } else {
            $this->department = null;
        }
    }

    public function updatedSearch($value, $key)
    {
        if (in_array($key, ['department', 'email', 'notes'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $departmentSearch = '%' . $this->search['department'] . '%';
        $emailSearch = '%' . $this->search['email'] . '%';
        $notesSearch = '%' . $this->search['notes'] . '%';

        $Emaillists = Emaillists::query()
            ->when($this->search['department'], function ($query) use ($departmentSearch) {
                $query->where(function ($subQuery) use ($departmentSearch) {
                    // البحث في الأقسام فقط عندما يكون النوع section
                    $subQuery->where(function ($q) use ($departmentSearch) {
                        $q->where('type', 'section')
                          ->whereHas('Getsection', function ($q) use ($departmentSearch) {
                              $q->where('section_name', 'LIKE', $departmentSearch);
                          });
                    })
                    // البحث في الدوائر فقط عندما يكون النوع department
                    ->orWhere(function ($q) use ($departmentSearch) {
                        $q->where('type', 'department')
                          ->whereHas('Getdepartment', function ($q) use ($departmentSearch) {
                              $q->where('department_name', 'LIKE', $departmentSearch);
                          });
                    });
                });
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

        // الحصول على اسم القسم/الدائرة
        $departmentName = '';
        if ($this->type == 'section') {
            $section = Sections::find($this->department);
            $departmentName = $section ? $section->section_name : '';
        } else {
            $department = Departments::find($this->department);
            $departmentName = $department ? $department->department_name : '';
        }

        Emaillists::create([
            'user_id' => Auth::id(),
            'type' => $this->type,
            'department' => $this->department,
            'email' => $this->email,
            'notes' => $this->notes,
        ]);

        Tracking::create([
            'user_id' => Auth::id(),
            'page_name' => 'قائمة البريد الإلكتروني',
            'operation_type' => 'اضافة',
            'operation_time' => now()->format('Y-m-d H:i:s'),
            'details' => "النوع: " . ($this->type == 'section' ? 'قسم' : 'دائرة') . "\n"
                . "القسم/الدائرة: " . $departmentName . "\n"
                . "البريد الإلكتروني: " . $this->email . "\n"
                . "الملاحظات: " . $this->notes,
        ]);
        // =================================
        $this->reset(['department', 'email', 'notes']);
        $this->emit('refreshData');  // إضافة هذا السطر
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
        $this->department = $this->emaillist->department; // نحفظ ID القسم/الدائرة
        $this->email = $this->emaillist->email;
        $this->notes = $this->emaillist->notes;

        // لضمان تحديث القيمة في Select2 بعد تحميل البيانات
        $this->dispatchBrowserEvent('updateSelect2', [
            'selector' => '#editEmaillistdepartment',
            'value' => $this->department
        ]);
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

        // الحصول على اسم القسم/الدائرة
        $departmentName = '';
        if ($this->type == 'section') {
            $section = Sections::find($this->department);
            $departmentName = $section ? $section->section_name : '';
        } else {
            $department = Departments::find($this->department);
            $departmentName = $department ? $department->department_name : '';
        }

        $Emaillists->update([
            'user_id' => Auth::id(),
            'type' => $this->type,
            'department' => $this->department,
            'email' => $this->email,
            'notes' => $this->notes,
        ]);

        Tracking::create([
            'user_id' => Auth::id(),
            'page_name' => 'قائمة البريد الإلكتروني',
            'operation_type' => 'تعديل',
            'operation_time' => now()->format('Y-m-d H:i:s'),
            'details' => "النوع: " . ($this->type == 'section' ? 'قسم' : 'دائرة') . "\n"
                . "القسم/الدائرة: " . $departmentName . "\n"
                . "البريد الإلكتروني: " . $this->email . "\n"
                . "الملاحظات: " . $this->notes,
        ]);
        // =================================
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
            // الحصول على اسم القسم/الدائرة
            $departmentName = '';
            if ($Emaillists->type == 'section') {
                $section = Sections::find($Emaillists->department);
                $departmentName = $section ? $section->section_name : '';
            } else {
                $department = Departments::find($Emaillists->department);
                $departmentName = $department ? $department->department_name : '';
            }

            Tracking::create([
                'user_id' => Auth::id(),
                'page_name' => 'قائمة البريد الإلكتروني',
                'operation_type' => 'حذف',
                'operation_time' => now()->format('Y-m-d H:i:s'),
                'details' => "النوع: " . ($Emaillists->type == 'section' ? 'قسم' : 'دائرة') . "\n"
                    . "القسم/الدائرة: " . $departmentName . "\n"
                    . "البريد الإلكتروني: " . $Emaillists->email . "\n"
                    . "الملاحظات: " . $Emaillists->notes,
            ]);

            $Emaillists->delete();
            $this->reset();
            $this->dispatchBrowserEvent('success', [
                'message' => 'تم حذف البيانات بنجاح',
                'title' => 'الحذف'
            ]);
        }
    }
}
