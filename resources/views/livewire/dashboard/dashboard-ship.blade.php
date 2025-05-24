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

    <!-- Daily Statistics Chart -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">احصائيات الكتب اليومية</h5>
                </div>
                <div class="card-body">
                    <div id="dailyStatsChart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Importance Distribution Chart & Recent Books -->
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">توزيع درجة الأهمية</h5>
                </div>
                <div class="card-body">
                    <div id="importanceChart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">آخر الكتب المضافة</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>رقم الكتاب</th>
                                    <th>التاريخ</th>
                                    <th>الموضوع</th>
                                    <th>النوع</th>
                                    <th>الأهمية</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentBooks as $book)
                                    <tr>
                                        <td>{{ $book->book_number }}</td>
                                        <td>{{ Carbon\Carbon::parse($book->book_date)->format('Y-m-d') }}</td>
                                        <td>{{ Str::limit($book->subject, 30) }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $book->book_type == 'وارد' ? 'primary' : 'success' }}">
                                                {{ $book->book_type }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $book->importance == 'عاجل' ? 'danger' : ($book->importance == 'سري' ? 'warning' : 'info') }}">
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
                    height: 300,
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    categories: @json($dailyStats->keys())
                },
                tooltip: {
                    shared: true
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
                    height: 300
                },
                legend: {
                    position: 'bottom'
                }
            };

            var importanceChart = new ApexCharts(document.querySelector("#importanceChart"), importanceOptions);
            importanceChart.render();
        </script>
    @endpush
</div>
