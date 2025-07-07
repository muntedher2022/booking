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
        // **هذا هو الجزء الأهم لمنع الخطأ:**
        // يتم استدعاء الدوال فقط إذا كان هناك مستخدم مسجل الدخول
        if (auth()->check()) {
            $this->loadDailyStats();
            $this->loadRecentBooks();
            $this->loadTotalStats();
        } else {
            // إذا لم يكن هناك مستخدم مسجل الدخول، قم بتهيئة المتغيرات بقيم افتراضية
            // أو يمكنك توجيه المستخدم لصفحة تسجيل الدخول
            $this->dailyStats = [];
            $this->recentBooks = collect();
            $this->totalIncoming = 0;
            $this->totalOutgoing = 0;
            $this->totalBooks = 0;
            $this->todayGrowthIncoming = 0;
            $this->todayGrowthOutgoing = 0;
            $this->importanceStats = [];
            $this->incomingInternalCount = 0;
            $this->incomingExternalCount = 0;
            $this->outgoingInternalCount = 0;
            $this->outgoingExternalCount = 0;
        }
    }

    private function loadDailyStats()
    {
        $startDate = now()->subDays(6)->startOfDay();
        $endDate = now()->endOfDay();

        $stats = [];
        for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
            $dateString = $date->format('Y-m-d');
            $stats[$dateString] = [
                'date' => $dateString,
                'incoming' => 0,
                'outgoing' => 0
            ];
        }

        // **الخطوة الثانية:** جلب معرفات أقسام المستخدم مع استخدام `?? []`
        // هذا السطر لن يتم تنفيذه إلا إذا كان `auth()->check()` صحيحًا
        $userSectionIds = auth()->user()->sections->pluck('id')->toArray() ?? [];
        $usersInSameSections = User::whereHas('sections', function ($q) use ($userSectionIds) {
            $q->whereIn('sections.id', $userSectionIds);
        })->pluck('id')->unique()->toArray();

        $results = Incomingbooks::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('user_id', $usersInSameSections)
            ->selectRaw('DATE(created_at) as date, book_type, COUNT(*) as count')
            ->groupBy('date', 'book_type')
            ->orderBy('date')
            ->get();

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
        Log::info('Daily Stats:', $stats);
    }

    private function loadRecentBooks()
    {
        // جلب معرفات أقسام المستخدم فقط إذا كانت الأقسام موجودة، وإلا فمصفوفة فارغة
        $userSectionIds = auth()->user()->sections->pluck('id')->toArray() ?? [];
        $usersInSameSections = User::whereHas('sections', function ($q) use ($userSectionIds) {
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

        // التأكد من وجود علاقة الأقسام قبل استدعاء pluck()، وإلا فمصفوفة فارغة
        $userSectionIds = auth()->user()->sections->pluck('id')->toArray() ?? [];

        // إذا لم تكن هناك معرفات أقسام، فلا داعي للاستعلام عن المستخدمين في نفس الأقسام؛
        // يتم تعيينها افتراضيًا على معرف المستخدم الحالي لمنع وجود مصفوفة فارغة في whereIn
        if (empty($userSectionIds)) {
            $usersInSameSections = [auth()->id()];
        } else {
            $usersInSameSections = User::whereHas('sections', function ($q) use ($userSectionIds) {
                $q->whereIn('sections.id', $userSectionIds);
            })->pluck('id')->unique()->toArray();
        }

        // إحصائيات الكتب الواردة
        $this->totalIncoming = Incomingbooks::where('book_type', 'وارد')
            ->whereIn('user_id', $usersInSameSections)
            ->count();
        $this->todayGrowthIncoming = Incomingbooks::where('book_type', 'وارد')
            ->whereIn('user_id', $usersInSameSections)
            ->whereDate('created_at', $today)
            ->count();

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

        $this->outgoingInternalCount = Incomingbooks::where('book_type', 'صادر')
            ->where('sender_type', 'داخلي')
            ->whereIn('user_id', $usersInSameSections)
            ->count();
        $this->outgoingExternalCount = Incomingbooks::where('book_type', 'صادر')
            ->where('sender_type', 'خارجي')
            ->whereIn('user_id', $usersInSameSections)
            ->count();

        $this->totalBooks = $this->totalIncoming + $this->totalOutgoing;

        // إحصائيات درجات الأهمية
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
