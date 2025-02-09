<?php

namespace App\Http\Livewire\Departments;

use Livewire\Component;

use Livewire\WithPagination;
use App\Models\Departments\Departments;
use Illuminate\Support\Facades\Auth;

class Department extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $Departments = [];
    public $department, $departmentId;
    public $department_name;
    public $search = ['department_name' => ''];

    public function updatedSearch($value, $key)
    {
        if (in_array($key, ['department_name'])) {
            $this->resetPage();
        }
    }

    public function render()
    {

        $department_nameSearch = '%' . $this->search['department_name'] . '%';
        $Departments = Departments::query()
            ->when($this->search['department_name'], function ($query) use ($department_nameSearch) {
                $query->where('department_name', 'LIKE', $department_nameSearch);
            })

            ->orderBy('id', 'ASC')
            ->paginate(10);

        $links = $Departments;
        $this->Departments = collect($Departments->items());

        return view('livewire.departments.department', [
            'Departments' => $Departments,
            'links' => $links
        ]);
    }

    public function AddDepartmentModalShow()
    {
        $this->reset();
        $this->resetValidation();
        $this->dispatchBrowserEvent('DepartmentModalShow');
    }


    public function store()
    {
        $this->resetValidation();
        $this->validate([
            'department_name' => 'required|unique:departments,department_name',

        ], [
            'department_name.required' => 'حقل اسم الدائرة مطلوب',
            'department_name.unique' => 'حقل اسم الدائرة موجود',
        ]);


        Departments::create([
            'user_id' => Auth::User()->id,
            'department_name' => $this->department_name,

        ]);
        $this->reset();
        $this->dispatchBrowserEvent('success', [
            'message' => 'تم الاضافه بنجاح',
            'title' => 'اضافه'
        ]);
    }

    public function GetDepartment($departmentId)
    {
        $this->resetValidation();

        $this->department  = Departments::find($departmentId);
        $this->departmentId = $this->department->id;
        $this->department_name = $this->department->department_name;
    }

    public function update()
    {
        $this->resetValidation();
        $this->validate([
            'department_name' => 'required|unique:departments,department_name',


        ], [
            'department_name.required' => 'حقل اسم الدائرة مطلوب',
            'department_name.unique' => 'حقل اسم الدائرة موجود',
        ]);

        $Departments = Departments::find($this->departmentId);
        $Departments->update([
            'user_id' => Auth::User()->id,
            'department_name' => $this->department_name,

        ]);
        $this->reset();
        $this->dispatchBrowserEvent('success', [
            'message' => 'تم التعديل بنجاح',
            'title' => 'تعديل'
        ]);
    }

    public function destroy()
    {
        $Departments = Departments::find($this->departmentId);

        if ($Departments) {

            $Departments->delete();
            $this->reset();
            $this->dispatchBrowserEvent('success', [
                'message' => 'تم حذف البيانات بنجاح',
                'title' => 'الحذف'
            ]);
        }
    }
}
