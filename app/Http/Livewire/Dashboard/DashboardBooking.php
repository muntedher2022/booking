<?php

namespace App\Http\Livewire\Dashboard;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use App\Models\Incomingbooks\Incomingbooks;

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
        $startDate = now()->subDays(6)->startOfDay();
        $endDate = now()->endOfDay();

        // تهيئة مصفوفة البيانات لكل يوم
        $stats = [];
        for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
            $dateString = $date->format('Y-m-d');
            $stats[$dateString] = [
                'date' => $dateString,
                'incoming' => 0,
                'outgoing' => 0
            ];
        }

        // جلب البيانات من قاعدة البيانات
        $results = Incomingbooks::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, book_type, COUNT(*) as count')
            ->groupBy('date', 'book_type')
            ->orderBy('date')
            ->get();

        // تعبئة البيانات الفعلية
        foreach ($results as $result) {
            $dateStr = $result->date;
            if (isset($stats[$dateStr])) {
                if ($result->book_type === 'وارد') {
                    $stats[$dateStr]['incoming'] = (int)$result->count;
                } else {
                    $stats[$dateStr]['outgoing'] = (int)$result->count;
                }
            }
        }

        $this->dailyStats = $stats;

        // للتأكد من البيانات
        Log::info('Daily Stats:', $stats);
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
