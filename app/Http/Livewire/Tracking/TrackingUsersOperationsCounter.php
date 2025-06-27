<?php

namespace App\Http\Livewire\Tracking;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Tracking\Tracking;
use Illuminate\Support\Facades\DB;

class TrackingUsersOperationsCounter extends Component
{
    public $usersDailyCounts = [];

    protected $listeners = ['refreshCounter' => 'updateTrackingUsersOperationsCounter'];

    public function mount()
    {
        $this->updateTrackingUsersOperationsCounter();
    }

    public function render()
    {
        return view('livewire.tracking.tracking-users-operations-counter');
    }

    public function updateTrackingUsersOperationsCounter()
    {
        date_default_timezone_set('Asia/Baghdad');
        $this->usersDailyCounts = Tracking::whereDate('operation_time', Carbon::today())
            ->select('user_id', DB::raw('count(*) as daily_count'))
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');
    }
}
