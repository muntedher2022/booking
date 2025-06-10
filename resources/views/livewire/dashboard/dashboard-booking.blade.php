<div>
    <!-- Statistics Cards -->
    <div class="row mb-5 justify-content-center g-4">
        <div class="col-md-8 col-lg-6">
            <div class="card backdrop-blur-sm border-0 shadow-lg hover-shadow-lg transition-all overflow-hidden">
                <!-- إضافة الخلفية والووترمارك -->
                <div class="position-absolute top-0 start-0 w-100 h-100">
                    <div class="watermark-image incoming"></div>
                </div>
                <div class="card-body position-relative p-5">
                    <div class="d-flex align-items-center mb-4 justify-content-center">
                        <div class="avatar-wrapper me-3">
                            <div class="avatar-circle">
                                <i class="mdi mdi-email-arrow-left mdi-36px text-primary"></i>
                            </div>
                        </div>
                        <div class="text-center">
                            <h5 class="mb-1 fw-bold text-primary fs-4">الكتب الواردة</h5>
                            <small class="text-muted">إجمالي عدد الكتب الواردة</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center gap-4">
                        <div class="text-center">
                            <h2 class="display-3 fw-bold mb-0 text-gradient animated-number" data-target="{{ $totalIncoming }}">0</h2>
                            <div class="trend-indicator positive mt-2">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <i class="mdi mdi-trending-up fs-4"></i>
                                    <div class="d-flex flex-column">
                                        <span class="fs-6">الكتب المضافة اليوم</span>
                                        <span class="fs-5 fw-bold">{{ $todayGrowthIncoming }} كتاب</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2 text-muted">
                                <span class="fw-semibold">إجمالي الكتب الواردة:</span>
                                <span class="fs-5 ms-1">{{ number_format($totalIncoming) }} كتاب</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-lg-6">
            <div class="card backdrop-blur-sm border-0 shadow-lg hover-shadow-lg transition-all overflow-hidden">
                <!-- إضافة الخلفية والووترمارك -->
                <div class="position-absolute top-0 start-0 w-100 h-100">
                    <div class="watermark-image outgoing"></div>
                </div>
                <div class="card-body position-relative p-5">
                    <div class="d-flex align-items-center mb-4 justify-content-center">
                        <div class="avatar-wrapper me-3">
                            <div class="avatar-circle success">
                                <i class="mdi mdi-email-arrow-right mdi-36px text-success"></i>
                            </div>
                        </div>
                        <div class="text-center">
                            <h5 class="mb-1 fw-bold text-success fs-4">الكتب الصادرة</h5>
                            <small class="text-muted">إجمالي عدد الكتب الصادرة</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center gap-4">
                        <div class="text-center">
                            <h2 class="display-3 fw-bold mb-0 text-gradient animated-number" data-target="{{ $totalOutgoing }}">0</h2>
                            <div class="trend-indicator positive mt-2">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <i class="mdi mdi-trending-up fs-4"></i>
                                    <div class="d-flex flex-column">
                                        <span class="fs-6">الكتب المضافة اليوم</span>
                                        <span class="fs-5 fw-bold">{{ $todayGrowthOutgoing }} كتاب</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2 text-muted">
                                <span class="fw-semibold">إجمالي الكتب الصادرة:</span>
                                <span class="fs-5 ms-1">{{ number_format($totalOutgoing) }} كتاب</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="watermark-icon success">
                    <i class="mdi mdi-email-arrow-right"></i>
                </div> -->
            </div>
        </div>
    </div>

    <style>
        /* Custom styles for a more modern look */
        .card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            overflow: hidden;
            /* Ensures rounded corners are respected */
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .card-title {
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        /* Animation for numbers (requires a bit of JS) */
        .animated-number {
            font-family: 'Poppins', sans-serif;
            /* Example: use a modern font */
        }

        /* Basic FadeInUp animation for cards (if using Animate.css or similar) */
        @keyframes fadeInUpx {
            from {
                opacity: 0;
                transform: translate3d(0, 20px, 0);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .animate__animated.animate__fadeInUp {
            animation-name: fadeInUpx;
            animation-duration: 0.8s;
            animation-fill-mode: both;
        }

        .animate__delay-1s {
            animation-delay: 0.5s;
            /* Adjusted for better flow */
        }

        .transition-all {
            transition: all 0.3s ease-in-out;
        }

        .hover-shadow-lg:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important;
        }

        .avatar {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bg-label-primary {
            background-color: rgba(105, 108, 255, 0.16) !important;
            color: #696cff !important;
        }

        .bg-label-success {
            background-color: rgba(113, 221, 55, 0.16) !important;
            color: #71dd37 !important;
        }

        .chart-sparkline {
            width: 100px;
            height: 30px;
            position: relative;
            opacity: 0.5;
        }

        .chart-sparkline.positive {
            background: linear-gradient(45deg, transparent 45%, #71dd37 45%, #71dd37 55%, transparent 55%),
                        linear-gradient(45deg, transparent 45%, #71dd37 45%, #71dd37 55%, transparent 55%),
                        linear-gradient(45deg, transparent 45%, #71dd37 45%, #71dd37 55%, transparent 55%);
            background-size: 10px 10px;
            background-position: 0 0, 5px 5px, 10px 10px;
        }

        .avatar-xl {
            width: 60px;
            height: 60px;
        }

        .trend-indicator {
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .trend-indicator.positive {
            color: #71dd37;
            background-color: rgba(113, 221, 55, 0.1);
        }

        .trend-indicator.positive i {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-3px);
            }
            100% {
                transform: translateY(0);
            }
        }

        /* تحديث الستايلات */
        .backdrop-blur-sm {
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        .text-gradient {
            background: linear-gradient(45deg, #696cff, #8592a3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .bg-primary-subtle {
            background: linear-gradient(135deg, #696cff15 0%, #8592a315 100%);
        }

        .trend-indicator {
            border-radius: 1rem;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .trend-indicator.positive {
            background: rgba(113, 221, 55, 0.1);
            color: #71dd37;
            box-shadow: 0 0 20px rgba(113, 221, 55, 0.2);
        }

        .avatar {
            transition: transform 0.3s ease;
        }

        .card:hover .avatar {
            transform: scale(1.1) rotate(5deg);
        }

        .animated-number {
            font-size: 4rem;
            line-height: 1;
            margin: 1rem 0;
            position: relative;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .card:hover .animated-number {
            animation: float 3s ease-in-out infinite;
        }

        /* تحسين الظلال والتأثيرات */
        .shadow-lg {
            box-shadow: 0 10px 25px -5px rgba(105, 108, 255, 0.1) !important;
        }

        .hover-shadow-lg:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 30px -10px rgba(105, 108, 255, 0.2) !important;
        }

        .avatar-wrapper {
            position: relative;
            display: inline-flex;
        }

        .avatar-circle {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: rgba(105, 108, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 0 5px rgba(105, 108, 255, 0.05);
            transition: all 0.3s ease;
        }

        .avatar-circle.success {
            background: rgba(113, 221, 55, 0.1);
            box-shadow: 0 0 0 5px rgba(113, 221, 55, 0.05);
        }

        .mdi-36px {
            font-size: 36px !important;
        }

        .card:hover .avatar-circle {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 0 0 8px rgba(105, 108, 255, 0.08);
        }

        .card:hover .avatar-circle.success {
            box-shadow: 0 0 0 8px rgba(113, 221, 55, 0.08);
        }

        .watermark-image {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 65%;
            height: 65%;
            opacity: 0.05;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            transition: all 0.3s ease;
        }

        .watermark-image.incoming {
            background-image: url('/assets/img/logo/Incoming.png');
        }

        .watermark-image.outgoing {
            background-image: url('/assets/img/logo/Outgoing.png');
        }

        .card:hover .watermark-image {
            opacity: 0.08;
            transform: translate(-50%, -50%) scale(1.05);
        }

        /* ضمان أن محتوى الكارد يظهر فوق الصورة */
        .card-body {
            position: relative;
            z-index: 1;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const numbers = document.querySelectorAll('.animated-number');

            numbers.forEach(number => {
                const target = parseInt(number.getAttribute('data-target'));
                let current = 0;
                const increment = target / 10; // تم تقليل عدد الخطوات من 200 إلى 50

                const updateNumber = () => {
                    if (current < target) {
                        current += increment;
                        number.textContent = Math.ceil(current);
                        requestAnimationFrame(updateNumber);
                    } else {
                        number.textContent = target;
                    }
                };

                setTimeout(() => {
                    requestAnimationFrame(updateNumber);
                }, 100); // تم تقليل وقت التأخير من 800 إلى 300
            });
        });
    </script>

    <!-- Importance Distribution & Recent Books -->
    <div class="row g-4">
        <div class="col">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pt-4 pb-2">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <i class="mdi mdi-clock-outline me-2 text-info"></i>
                        آخر الكتب المضافة
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 px-4">رقم الكتاب</th>
                                    <th class="border-0">التاريخ</th>
                                    <th class="border-0">الموضوع</th>
                                    <th class="border-0">النوع</th>
                                    <th class="border-0">الأهمية</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentBooks as $book)
                                    <tr>
                                        <td class="px-4">{{ $book->book_number }}</td>
                                        <td>{{ Carbon\Carbon::parse($book->book_date)->format('Y-m-d') }}</td>
                                        <td>{{ Str::limit($book->subject, 30) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $book->book_type == 'وارد' ? 'soft-primary' : 'soft-success' }} rounded-pill px-3">
                                                {{ $book->book_type }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                $importanceClass = match($book->importance) {
                                                    'عاجل' => 'soft-danger',
                                                    'سري' => 'soft-warning',
                                                    default => 'soft-info'
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $importanceClass }} rounded-pill px-3">
                                                {{ $book->importance }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .dashboard-container {
            padding: 1.5rem;
        }

        .stat-card {
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
        }

        .bg-gradient-primary {
            background: linear-gradient(45deg, #4e73df, #224abe);
        }

        .bg-gradient-success {
            background: linear-gradient(45deg, #1cc88a, #13855c);
        }

        .bg-soft-primary {
            background-color: rgba(78, 115, 223, 0.1) !important;
            color: #4e73df !important;
        }

        .bg-soft-success {
            background-color: rgba(28, 200, 138, 0.1) !important;
            color: #1cc88a !important;
        }

        .bg-soft-danger {
            background-color: rgba(231, 74, 59, 0.1) !important;
            color: #e74a3b !important;
        }

        .bg-soft-warning {
            background-color: rgba(246, 194, 62, 0.1) !important;
            color: #f6c23e !important;
        }

        .bg-soft-info {
            background-color: rgba(54, 185, 204, 0.1) !important;
            color: #36b9cc !important;
        }

        .counter-up {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.5s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Daily Statistics Chart
        var dailyStatsOptions = {
            series: [{
                name: 'كتب واردة',
                data: @json($dailyStats->pluck('incoming'))
            }, {
                name: 'كتب صادرة',
                data: @json($dailyStats->pluck('outgoing'))
            }],
            chart: {
                type: 'area',
                height: 350,
                toolbar: {
                    show: false
                },
                fontFamily: 'inherit',
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                    animateGradually: {
                        enabled: true,
                        delay: 150
                    }
                }
            },
            colors: ['#4e73df', '#1cc88a'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.1,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: @json($dailyStats->keys())
            },
            tooltip: {
                shared: true,
                theme: 'dark',
                x: {
                    format: 'yyyy-MM-dd'
                }
            }
        };

        var dailyStatsChart = new ApexCharts(document.querySelector("#dailyStatsChart"), dailyStatsOptions);
        dailyStatsChart.render();

        // Importance Distribution Chart
        var importanceOptions = {
            series: @json($importanceStats->pluck('count')),
            labels: @json($importanceStats->pluck('importance')),
            chart: {
                type: 'donut',
                height: 300,
                fontFamily: 'inherit',
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                    animateGradually: {
                        enabled: true,
                        delay: 150
                    }
                }
            },
            colors: ['#4e73df', '#1cc88a', '#f6c23e', '#e74a3b'],
            legend: {
                position: 'bottom',
                fontFamily: 'inherit'
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%'
                    }
                }
            },
            tooltip: {
                theme: 'dark'
            }
        };

        var importanceChart = new ApexCharts(document.querySelector("#importanceChart"), importanceOptions);
        importanceChart.render();
    </script>
    @endpush
</div>
