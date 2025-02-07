<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class DashboardShip extends Component
{
    public function render()
    {
        return view('livewire.dashboard.dashboard-ship');
    }
    public $boycottsCount,$propertyCount,$bondsCount;

    public function mount()
    {
        /* $this->boycottsCount = Provinces::count();
        $this->bondsCount = Realitie::count(); */
        // $this->propertyCount = Property::where('isdeleted', 0)->count();
    }
}
