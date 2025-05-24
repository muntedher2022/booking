<div>
    <!-- Statistics Cards -->
    <div class="row mb-5 justify-content-center">
        <div class="col-md-5 col-lg-4 mb-4">
            <div class="card shadow-sm border-0 rounded-lg h-100 animate__animated animate__fadeInUp">
                <div class="card-body text-center p-4">
                    <h5 class="card-title text-muted fw-bold mb-3">الكتب الواردة</h5>
                    <h2 class="display-4 fw-bolder text-primary mb-3 animated-number" data-target="{{ $totalIncoming }}">0
                    </h2>
                    <p class="card-text text-secondary mb-0">إجمالي عدد الكتب الواردة</p>
                </div>
            </div>
        </div>
        <div class="col-md-5 col-lg-4 mb-4">
            <div class="card shadow-sm border-0 rounded-lg h-100 animate__animated animate__fadeInUp animate__delay-1s">
                <div class="card-body text-center p-4">
                    <h5 class="card-title text-muted fw-bold mb-3">الكتب الصادرة</h5>
                    <h2 class="display-4 fw-bolder text-success mb-3 animated-number"
                        data-target="{{ $totalOutgoing }}">0</h2>
                    <p class="card-text text-secondary mb-0">إجمالي عدد الكتب الصادرة</p>
                </div>
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
    </style>

    <script>
        // JavaScript for animating the numbers (optional, but adds a nice touch)
        document.addEventListener('DOMContentLoaded', () => {
            const numbers = document.querySelectorAll('.animated-number');

            numbers.forEach(number => {
                const target = parseInt(number.getAttribute('data-target'));
                let current = 0;
                const increment = target / 200; // Adjust speed

                const updateNumber = () => {
                    if (current < target) {
                        current += increment;
                        number.textContent = Math.ceil(current);
                        requestAnimationFrame(updateNumber);
                    } else {
                        number.textContent = target;
                    }
                };
                setTimeout(() => { // Delay start slightly after card animation
                    requestAnimationFrame(updateNumber);
                }, 800); // Match or slightly exceed card animation delay
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
