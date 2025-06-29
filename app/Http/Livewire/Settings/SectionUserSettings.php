<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\User;
use App\Models\Sections\Sections;

class SectionUserSettings extends Component
{
    public $sections = [];
    public $users = [];
    public $selectedSection;
    public $selectedUsers = [];

    public function mount()
    {
        $this->sections = Sections::all();
        $this->users = User::all();
    }

    public function updatedSelectedSection($sectionId)
    {
        if ($sectionId) {
            $section = Sections::find($sectionId);
            $this->selectedUsers = $section->user()->pluck('users.id')->toArray();
        } else {
            $this->selectedUsers = [];
        }
    }

    public function store()
    {
        if ($this->selectedSection) {
            $section = Sections::find($this->selectedSection);
            $section->user()->sync($this->selectedUsers);
            $this->dispatchBrowserEvent('success', [
                'message' => 'تم حفظ الربط بنجاح',
                'title' => 'نجاح'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.settings.section-user-settings');
    }
}
