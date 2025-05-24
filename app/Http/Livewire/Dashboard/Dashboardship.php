<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Incomingbooks\Incomingbooks;
use Carbon\Carbon;
use Livewire\Component;

class DashboardShip extends Component
{
    public $dailyStats;
    public $recentBooks;
    public $totalIncoming;
    public $totalOutgoing;
    public $importanceStats;

    public function mount()
    {
        $this->loadDailyStats();
        $this->loadRecentBooks();
        $this->loadTotalStats();
        $this->loadImportanceStats();
    }

    private function loadDailyStats()
    {
        $startDate = Carbon::now()->subDays(7);

        $this->dailyStats = Incomingbooks::where('book_date', '>=', $startDate)
            ->selectRaw('DATE(book_date) as date, book_type, COUNT(*) as count')
            ->groupBy('date', 'book_type')
            ->orderBy('date')
            ->get()
            ->groupBy('date')
            ->map(function ($group) {
                return [
                    'incoming' => $group->where('book_type', 'وارد')->first()->count ?? 0,
                    'outgoing' => $group->where('book_type', 'صادر')->first()->count ?? 0
                ];
            });
    }

    private function loadRecentBooks()
    {
        $this->recentBooks = Incomingbooks::latest()
            ->take(10)
            ->get();
    }

    private function loadTotalStats()
    {
        $this->totalIncoming = Incomingbooks::where('book_type', 'وارد')->count();
        $this->totalOutgoing = Incomingbooks::where('book_type', 'صادر')->count();
    }

    private function loadImportanceStats()
    {
        $this->importanceStats = Incomingbooks::selectRaw('importance, COUNT(*) as count')
            ->groupBy('importance')
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard-ship');
    }
}
