<?php

namespace App\Http\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use App\Models\Incomingbooks\Incomingbooks;

class DashboardBooking extends Component
{
    public $dailyStats;
    public $recentBooks;
    public $totalIncoming;
    public $totalOutgoing;
    public $totalBooks;
    public $todayGrowthIncoming;
    public $todayGrowthOutgoing;
    public $importanceStats;

    public $incomingInternalCount;
    public $incomingExternalCount;
    public $outgoingInternalCount;
    public $outgoingExternalCount;

    public function mount()
    {
        $this->loadDailyStats();
        $this->loadRecentBooks();
        $this->loadTotalStats();
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
        // جلب معرفات الأقسام المرتبط بها المستخدم الحالي
        $userSectionIds = auth()->user()->sections->pluck('id')->toArray();

        // جلب جميع المستخدمين المرتبطين بنفس الأقسام
        $usersInSameSections = User::whereHas('sections', function($q) use ($userSectionIds) {
            $q->whereIn('sections.id', $userSectionIds);
        })->pluck('id')->unique()->toArray();

        $this->recentBooks = Incomingbooks::whereIn('user_id', $usersInSameSections)
            ->latest()
            ->take(10)
            ->get();
    }

    private function loadTotalStats()
    {
        $today = Carbon::today();

        // جلب معرفات الأقسام المرتبط بها المستخدم الحالي
        $userSectionIds = auth()->user()->sections->pluck('id')->toArray();

        // جلب جميع المستخدمين المرتبطين بنفس الأقسام
        $usersInSameSections = User::whereHas('sections', function($q) use ($userSectionIds) {
            $q->whereIn('sections.id', $userSectionIds);
        })->pluck('id')->unique()->toArray();

        // إحصائيات الكتب الواردة والصادرة للمستخدمين المرتبطين بنفس الأقسام فقط
        $this->totalIncoming = Incomingbooks::where('book_type', 'وارد')
            ->whereIn('user_id', $usersInSameSections)
            ->count();
        $this->todayGrowthIncoming = Incomingbooks::where('book_type', 'وارد')
            ->whereIn('user_id', $usersInSameSections)
            ->whereDate('created_at', $today)
            ->count();

        // إضافة إحصائيات تفصيلية للوارد
        $this->incomingInternalCount = Incomingbooks::where('book_type', 'وارد')
            ->where('sender_type', 'داخلي')
            ->whereIn('user_id', $usersInSameSections)
            ->count();
        $this->incomingExternalCount = Incomingbooks::where('book_type', 'وارد')
            ->where('sender_type', 'خارجي')
            ->whereIn('user_id', $usersInSameSections)
            ->count();

        // إحصائيات الكتب الصادرة
        $this->totalOutgoing = Incomingbooks::where('book_type', 'صادر')
            ->whereIn('user_id', $usersInSameSections)
            ->count();
        $this->todayGrowthOutgoing = Incomingbooks::where('book_type', 'صادر')
            ->whereIn('user_id', $usersInSameSections)
            ->whereDate('created_at', $today)
            ->count();

        // إضافة إحصائيات تفصيلية للصادر
        $this->outgoingInternalCount = Incomingbooks::where('book_type', 'صادر')
            ->where('sender_type', 'داخلي')
            ->whereIn('user_id', $usersInSameSections)
            ->count();
        $this->outgoingExternalCount = Incomingbooks::where('book_type', 'صادر')
            ->where('sender_type', 'خارجي')
            ->whereIn('user_id', $usersInSameSections)
            ->count();

        $this->totalBooks = $this->totalIncoming + $this->totalOutgoing;

        // تحديث إحصائيات درجات الأهمية للمستخدمين المرتبطين بنفس الأقسام فقط
        $importanceLevels = ['عادي', 'عاجل', 'سري', 'سري للغاية'];
        $this->importanceStats = [];

        foreach ($importanceLevels as $level) {
            $this->importanceStats[$level] = [
                'total' => Incomingbooks::where('importance', $level)
                    ->whereIn('user_id', $usersInSameSections)
                    ->count(),
                'today' => Incomingbooks::where('importance', $level)
                    ->whereIn('user_id', $usersInSameSections)
                    ->whereDate('created_at', $today)
                    ->count()
            ];
        }
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard-booking');
    }
}
