<?php

namespace App\Http\Livewire\Sections;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sections\Sections;
use App\Models\Tracking\Tracking;
use Illuminate\Support\Facades\Auth;

class Section extends Component
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
            'section_name.required' => 'يرجى إدخال اسم القسم',
            'section_name.unique' => 'هذا القسم موجود بالفعل'
        ]);


        Sections::create([
            'user_id' => Auth::User()->id,
            'section_name' => $this->section_name,

        ]);
        // =================================
        Tracking::create([
            'user_id' => Auth::id(),
            'page_name' => 'الأقسام',
            'operation_type' => 'اضافة',
            'operation_time' => now()->format('Y-m-d H:i:s'),
            'details' => "اسم القسم: " . $this->section_name,
        ]);
        // =================================
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
            'section_name' => 'required|unique:sections,section_name,'.$this->sectionId.',id'

        ], [
            'section_name.required' => 'يرجى إدخال اسم القسم',
            'section_name.unique' => 'هذا القسم موجود بالفعل'
        ]);

        $Sections = Sections::find($this->sectionId);
        $Sections->update([
            'user_id' => Auth::User()->id,
            'section_name' => $this->section_name,
        ]);
        // =================================
        Tracking::create([
            'user_id' => Auth::id(),
            'page_name' => 'الأقسام',
            'operation_type' => 'تعديل',
            'operation_time' => now()->format('Y-m-d H:i:s'),
            'details' => "اسم القسم: " . $this->section_name,
        ]);
        // =================================
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
            // =================================
            Tracking::create([
                'user_id' => Auth::id(),
                'page_name' => 'الأقسام',
                'operation_type' => 'حذف',
                'operation_time' => now()->format('Y-m-d H:i:s'),
                'details' => "اسم القسم: " . $Sections->section_name,
            ]);
            // =================================
            $Sections->delete();
            $this->reset();
            $this->dispatchBrowserEvent('success', [
                'message' => 'تم حذف البيانات بنجاح',
                'title' => 'الحذف'
            ]);
        }
    }
}
