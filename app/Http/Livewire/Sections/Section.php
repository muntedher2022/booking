<?php

namespace App\Http\Livewire\Sections;

use Livewire\Component;

use Livewire\WithPagination;
use App\Models\Sections\Sections;
use Illuminate\Support\Facades\Auth;

class section extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $Sections = [];
    public $section, $sectionId;
    public $section_name;
    public $search = ['section_name' => ''];

    public function updatedSearch($value, $key)
    {
        if (in_array($key, ['section_name'])) {
            $this->resetPage();
        }
    }

    public function render()
    {

        $section_nameSearch = '%' . $this->search['section_name'] . '%';
        $Sections = Sections::query()
            ->when($this->search['section_name'], function ($query) use ($section_nameSearch) {
                $query->where('section_name', 'LIKE', $section_nameSearch);
            })

            ->orderBy('id', 'ASC')
            ->paginate(10);

        $links = $Sections;
        $this->Sections = collect($Sections->items());

        return view('livewire.sections.section', [
            'Sections' => $Sections,
            'links' => $links
        ]);
    }

    public function AddsectionModalShow()
    {
        $this->reset();
        $this->resetValidation();
        $this->dispatchBrowserEvent('sectionModalShow');
    }


    public function store()
    {
        $this->resetValidation();
        $this->validate([
            'section_name' => 'required|unique:sections,section_name',

        ], [
            'section_name.required' => 'حقل اسم القسم مطلوب',
            'section_name.unique' => 'حقل اسم القسم موجود',
        ]);


        Sections::create([
            'user_id' => Auth::User()->id,
            'section_name' => $this->section_name,

        ]);
        $this->reset();
        $this->dispatchBrowserEvent('success', [
            'message' => 'تم الاضافه بنجاح',
            'title' => 'اضافه'
        ]);
    }

    public function GetSection($sectionId)
    {
        $this->resetValidation();

        $this->section  = Sections::find($sectionId);
        $this->sectionId = $this->section->id;
        $this->section_name = $this->section->section_name;
    }

    public function update()
    {
        $this->resetValidation();
        $this->validate([
            'section_name' => 'required|unique:sections,section_name',

        ], [
            'section_name.required' => 'حقل اسم القسم مطلوب',
            'section_name.unique' => 'حقل اسم القسم موجود',
        ]);

        $Sections = Sections::find($this->sectionId);
        $Sections->update([
            'user_id' => Auth::User()->id,
            'section_name' => $this->section_name,
        ]);
        $this->reset();
        $this->dispatchBrowserEvent('success', [
            'message' => 'تم التعديل بنجاح',
            'title' => 'تعديل'
        ]);
    }

    public function destroy()
    {
        $Sections = Sections::find($this->sectionId);

        if ($Sections) {

            $Sections->delete();
            $this->reset();
            $this->dispatchBrowserEvent('success', [
                'message' => 'تم حذف البيانات بنجاح',
                'title' => 'الحذف'
            ]);
        }
    }
}
