<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Incomingbooks\Incomingbooks;
use Carbon\Carbon;
use Livewire\Component;

class DashboardBooking extends Component
{
    public $dailyStats;
    public $recentBooks;
    public $totalIncoming;
    public $totalOutgoing;
    public $totalBooks;  // إجمالي الكتب
    public $todayGrowthIncoming;  // معدل النمو اليومي للوارد
    public $todayGrowthOutgoing;  // معدل النمو اليومي للصادر
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

        $this->dailyStats = Incomingbooks::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, book_type, COUNT(*) as count')
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
        $today = Carbon::today();

        // إحصائيات الكتب الواردة
        $this->totalIncoming = Incomingbooks::where('book_type', 'وارد')->count();
        $this->todayGrowthIncoming = Incomingbooks::where('book_type', 'وارد')
            ->whereDate('created_at', $today)
            ->count();

        // إحصائيات الكتب الصادرة
        $this->totalOutgoing = Incomingbooks::where('book_type', 'صادر')->count();
        $this->todayGrowthOutgoing = Incomingbooks::where('book_type', 'صادر')
            ->whereDate('created_at', $today)
            ->count();

        // إجمالي الكتب
        $this->totalBooks = $this->totalIncoming + $this->totalOutgoing;
    }

    private function loadImportanceStats()
    {
        $this->importanceStats = Incomingbooks::selectRaw('importance, COUNT(*) as count')
            ->groupBy('importance')
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard-booking');
    }
}
