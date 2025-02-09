<?php

namespace App\Http\Livewire\Owner\PermissionsRoles\Permissions;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class AccountPermissions extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $Permissions = [];
    public $PermissionSearch;
    public $name, $PermissionID;

    public function mount()
    {
        $this->Permissions = Permission::all();
    }

    public function render()
    {
        $Permissions = Permission::paginate(10);
        $links = $Permissions;
        $this->Permissions = collect($Permissions->items());

        return view('livewire.owner.permissions-roles.permissions.account-permissions', [
            'links' => $links 
        ]);
    }

    public function Search()
    {
        if($this->PermissionSearch != ''){
            $this->Permissions = Permission::WHERE('name', 'LIKE', $this->PermissionSearch . '%')->get();
            if(count($this->Permissions) == 0){
                $this->dispatchBrowserEvent('PermissionNotFond');
            }
        }else{
            $this->mount();
        }
    }

    public function AddPermissionModalShow()
    {
        $this->reset();
        $this->mount();
        $this->resetValidation();
        $this->dispatchBrowserEvent('PermissionModalShow');
    }

    public function store()
    {
        $this->resetValidation();

        $this->validate([
            'name' => 'required|unique:permissions,name',
        ],
        [
            'name.required' => 'أسم التصريح مطلوب',
            'name.unique' => 'أسم التصريج مستخدم سابقاً',
        ]);

        Permission::create([
            'name' => $this->name,
            'guard_name' => 'web'
        ]);

        $this->reset();
        $this->mount();

        $this->dispatchBrowserEvent('PermissionAddSuccess');
    }

    public function GetPermission($PermissionID)
    {
        $this->resetValidation();

        $this->PermissionID = $PermissionID;
        $PermissionName = Permission::find($PermissionID)->name;
        $this->name = $PermissionName;
    }

    public function update()
    {
        $this->resetValidation();
        $this->validate([
            'name' => 'required|unique:permissions,name,'.$this->PermissionID,
        ],
        [
            'name.required' => 'أسم التصريح مطلوب',
            'name.unique' => 'أسم التصريح مستخدم سابقاً',
        ]);

        $Permission = Permission::find($this->PermissionID);
        $Permission->update([
            'name' => $this->name
        ]);

        $this->reset();
        $this->mount();

        $this->dispatchBrowserEvent('PermissionUpdateSuccess');
    }

    /* public function remove($PermissionID)
    {
        $this->resetValidation();

        $this->PermissionID = $PermissionID;
        $PermissionName = Permission::find($PermissionID)->name;
        $this->name = $PermissionName;
    } */

    public function destroy()
    {
        Permission::find($this->PermissionID)->delete();

        $this->mount();

        $this->dispatchBrowserEvent('PermissionDestroySuccess');
    }
}
