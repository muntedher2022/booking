<div>
    @can('dashboard-view')
    <!-- Add Importance Statistics Cards -->
        <div class="row mb-5 justify-content-center g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card backdrop-blur-sm border-0 shadow-lg hover-shadow-lg transition-all overflow-hidden">
                    <div class="position-absolute top-0 start-0 w-100 h-100">
                        <div class="watermark-image normal"></div>
                    </div>
                    <div class="card-body position-relative p-4">
                        <div class="d-flex align-items-center mb-3 justify-content-center">
                            <div class="avatar-wrapper me-2">
                                <div class="avatar-circle info">
                                    <i class="mdi mdi-file-document mdi-24px text-info"></i>
                                </div>
                            </div>
                            <div class="text-center">
                                <h6 class="mb-0 fw-bold text-info">عادي</h6>
                            </div>
                        </div>
                        <div class="text-center">
                            <h3 class="fw-bold mb-1">{{ $importanceStats['عادي']['total'] }}</h3>
                            <div class="trend-indicator positive">
                                <small>اليوم: {{ $importanceStats['عادي']['today'] }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card backdrop-blur-sm border-0 shadow-lg hover-shadow-lg transition-all overflow-hidden">
                    <div class="position-absolute top-0 start-0 w-100 h-100">
                        <div class="watermark-image urgent"></div>
                    </div>
                    <div class="card-body position-relative p-4">
                        <div class="d-flex align-items-center mb-3 justify-content-center">
                            <div class="avatar-wrapper me-2">
                                <div class="avatar-circle warning">
                                    <i class="mdi mdi-clock-fast mdi-24px text-warning"></i>
                                </div>
                            </div>
                            <div class="text-center">
                                <h6 class="mb-0 fw-bold text-warning">عاجل</h6>
                            </div>
                        </div>
                        <div class="text-center">
                            <h3 class="fw-bold mb-1">{{ $importanceStats['عاجل']['total'] }}</h3>
                            <div class="trend-indicator positive">
                                <small>اليوم: {{ $importanceStats['عاجل']['today'] }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card backdrop-blur-sm border-0 shadow-lg hover-shadow-lg transition-all overflow-hidden">
                    <div class="position-absolute top-0 start-0 w-100 h-100">
                        <div class="watermark-image confidential"></div>
                    </div>
                    <div class="card-body position-relative p-4">
                        <div class="d-flex align-items-center mb-3 justify-content-center">
                            <div class="avatar-wrapper me-2">
                                <div class="avatar-circle danger">
                                    <i class="mdi mdi-shield-lock mdi-24px text-danger"></i>
                                </div>
                            </div>
                            <div class="text-center">
                                <h6 class="mb-0 fw-bold text-danger">سري</h6>
                            </div>
                        </div>
                        <div class="text-center">
                            <h3 class="fw-bold mb-1">{{ $importanceStats['سري']['total'] }}</h3>
                            <div class="trend-indicator positive">
                                <small>اليوم: {{ $importanceStats['سري']['today'] }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card backdrop-blur-sm border-0 shadow-lg hover-shadow-lg transition-all overflow-hidden">
                    <div class="position-absolute top-0 start-0 w-100 h-100">
                        <div class="watermark-image top-secret"></div>
                    </div>
                    <div class="card-body position-relative p-4">
                        <div class="d-flex align-items-center mb-3 justify-content-center">
                            <div class="avatar-wrapper me-2">
                                <div class="avatar-circle dark">
                                    <i class="mdi mdi-shield-alert mdi-24px text-dark"></i>
                                </div>
                            </div>
                            <div class="text-center">
                                <h6 class="mb-0 fw-bold text-dark">سري للغاية</h6>
                            </div>
                        </div>
                        <div class="text-center">
                            <h3 class="fw-bold mb-1">{{ $importanceStats['سري للغاية']['total'] }}</h3>
                            <div class="trend-indicator positive">
                                <small>اليوم: {{ $importanceStats['سري للغاية']['today'] }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                            <div class="text-center w-100">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <!-- Internal Books (Right) -->
                                    <div class="stats-detail flex-fill mx-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="stats-icon internal">
                                                <i class="mdi mdi-office-building mdi-24px"></i>
                                            </div>
                                            <div class="stats-info">
                                                <h6 class="mb-0 text-muted">الكتب الداخلية</h6>
                                                <span class="fs-4 fw-bold text-primary">{{ number_format($incomingInternalCount) }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Total Books (Center) -->
                                    <div class="d-flex flex-column align-items-center mx-4">
                                        <h2 class="display-3 fw-bold mb-0 text-gradient animated-number"
                                            data-target="{{ $totalIncoming }}">0</h2>
                                        <span class="fs-6 text-muted">الكتب الواردة</span>
                                    </div>

                                    <!-- External Books (Left) -->
                                    <div class="stats-detail flex-fill mx-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="stats-icon external">
                                                <i class="mdi mdi-domain mdi-24px"></i>
                                            </div>
                                            <div class="stats-info">
                                                <h6 class="mb-0 text-muted">الكتب الخارجية</h6>
                                                <span class="fs-4 fw-bold text-success">{{ number_format($incomingExternalCount) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="trend-indicator positive mt-2">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <i class="mdi mdi-trending-up fs-4"></i>
                                        <div class="d-flex flex-column">
                                            <span class="fs-6 text-primary">الكتب المضافة اليوم</span>
                                            <span class="fs-5 fw-bold">{{ $todayGrowthIncoming }} كتاب</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- تعديل تنسيق المخطط البياني -->
                                <div class="sparkline-box mt-4 mx-auto">
                                    <div class="chart-title text-center mb-2">
                                        <small class="text-muted">إحصائيات آخر 7 أيام - الكتب الواردة</small>
                                    </div>
                                    <div class="chart-container">
                                        <canvas id="incomingChart"></canvas>
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
                            <div class="text-center w-100">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <!-- Internal Books (Right) -->
                                    <div class="stats-detail flex-fill mx-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="stats-icon internal">
                                                <i class="mdi mdi-office-building mdi-24px"></i>
                                            </div>
                                            <div class="stats-info">
                                                <h6 class="mb-0 text-muted">الكتب الداخلية</h6>
                                                <span class="fs-4 fw-bold text-primary">{{ number_format($outgoingInternalCount) }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Total Books (Center) -->
                                    <div class="d-flex flex-column align-items-center mx-4">
                                        <h2 class="display-3 fw-bold mb-0 text-gradient animated-number"
                                            data-target="{{ $totalOutgoing }}">0</h2>
                                        <span class="fs-6 text-muted">الكتب الصادرة</span>
                                    </div>

                                    <!-- External Books (Left) -->
                                    <div class="stats-detail flex-fill mx-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="stats-icon external">
                                                <i class="mdi mdi-domain mdi-24px"></i>
                                            </div>
                                            <div class="stats-info">
                                                <h6 class="mb-0 text-muted">الكتب الخارجية</h6>
                                                <span class="fs-4 fw-bold text-success">{{ number_format($outgoingExternalCount) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="trend-indicator positive mt-2">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <i class="mdi mdi-trending-up fs-4"></i>
                                        <div class="d-flex flex-column">
                                            <span class="fs-6 text-primary">الكتب المضافة اليوم</span>
                                            <span class="fs-5 fw-bold">{{ $todayGrowthOutgoing }} كتاب</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- تعديل تنسيق المخطط البياني -->
                                <div class="sparkline-box mt-4 mx-auto">
                                    <div class="chart-title text-center mb-2">
                                        <small class="text-muted">إحصائيات آخر 7 أيام - الكتب الصادرة</small>
                                    </div>
                                    <div class="chart-container">
                                        <canvas id="outgoingChart"></canvas>
                                    </div>
                                </div>
                                <div class="mt-2 text-muted">
                                    <span class="fw-semibold">إجمالي الكتب الصادرة:</span>
                                    <span class="fs-5 ms-1">{{ number_format($totalOutgoing) }} كتاب</span>
                                </div>
                            </div>
                        </div>
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
                0% {
                    transform: translateY(0px);
                }

                50% {
                    transform: translateY(-10px);
                }

                100% {
                    transform: translateY(0px);
                }
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
                width: 80%;
                /* زيادة حجم الصورة */
                height: 80%;
                opacity: 0.04;
                /* تعديل الشفافية */
                background-size: contain;
                background-repeat: no-repeat;
                background-position: center;
                transition: all 0.5s ease;
                filter: grayscale(100%) contrast(120%);
                /* إضافة تأثيرات على الصورة */
                mix-blend-mode: multiply;
                /* تحسين مزج الصورة مع الخلفية */
            }

            .watermark-image.incoming {
                background-image: url('/assets/img/logo/Incoming.png');
                transform: translate(-50%, -50%) rotate(-5deg);
                /* إضافة دوران خفيف */
            }

            .watermark-image.outgoing {
                background-image: url('/assets/img/logo/Outgoing.png');
                transform: translate(-50%, -50%) rotate(5deg);
                /* إضافة دوران في الاتجاه المعاكس */
            }

            .watermark-image.normal {
                background-image: url('/assets/img/logo/normal.png');
            }

            .watermark-image.urgent {
                background-image: url('/assets/img/logo/urgent.png');
            }

            .watermark-image.confidential {
                background-image: url('/assets/img/logo/confidential.png');
            }

            .watermark-image.top-secret {
                background-image: url('/assets/img/logo/top-secret.png');
            }

            .card:hover .watermark-image {
                opacity: 0.06;
                filter: grayscale(80%) contrast(130%);
                /* تغيير التأثيرات عند التحويم */
                transform: translate(-50%, -50%) scale(1.05) rotate(0deg);
                /* تأثير حركي عند التحويم */
            }

            /* تحسين الانتقالات الحركية */
            .card {
                background: linear-gradient(145deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.95) 100%);
            }

            /* ضمان أن محتوى الكارد يظهر فوق الصورة */
            .card-body {
                position: relative;
                z-index: 1;
            }

            .sparkline-container {
                height: 60px;
                margin: 0 auto;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 10px;
                padding: 5px;
                box-shadow: inset 0 0 15px rgba(0, 0, 0, 0.05);
            }

            .sparkline-chart {
                width: 100% !important;
                height: 100% !important;
            }

            .sparkline-box {
                background: rgba(255, 255, 255, 0.1);
                border-radius: 15px;
                padding: 15px;
                width: 100%;
                max-width: 500px;
                /* زيادة العرض الأقصى من 300 إلى 400 */
                box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.05);
                backdrop-filter: blur(5px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                margin-bottom: 15px;
            }

            .chart-container {
                position: relative;
                height: 100px;
                /* زيادة الارتفاع من 80 إلى 100 */
                width: 100%;
                min-width: 300px;
                /* إضافة حد أدنى للعرض */
            }

            .chart-title {
                font-size: 0.875rem;
                color: #6c757d;
                margin-bottom: 10px;
            }

            .avatar-circle.info {
                background: rgba(13, 202, 240, 0.1);
            }

            .avatar-circle.warning {
                background: rgba(255, 193, 7, 0.1);
            }

            .avatar-circle.danger {
                background: rgba(220, 53, 69, 0.1);
            }

            .avatar-circle.dark {
                background: rgba(33, 37, 41, 0.1);
            }

            .stats-detail {
                padding: 0.75rem;
                border-radius: 0.75rem;
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(5px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                transition: all 0.3s ease;
            }

            .stats-detail:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }

            .stats-icon {
                width: 45px;
                height: 45px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease;
            }

            .stats-icon.internal {
                background: rgba(105, 108, 255, 0.1);
                color: #696cff;
            }

            .stats-icon.external {
                background: rgba(113, 221, 55, 0.1);
                color: #71dd37;
            }

            .stats-info {
                flex: 1;
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
                                                <span
                                                    class="badge bg-{{ $book->book_type == 'وارد' ? 'soft-primary' : 'soft-success' }} rounded-pill px-3">
                                                    {{ $book->book_type }}
                                                </span>
                                            </td>
                                            <td>
                                                @php
                                                    $importanceClass = match ($book->importance) {
                                                        'عاجل' => 'soft-danger',
                                                        'سري' => 'soft-warning',
                                                        default => 'soft-info',
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
            <script>
                window.addEventListener('livewire:load', function() {
                    console.log('Chart Data:', @json($dailyStats));

                    const statsData = @json($dailyStats);
                    const dates = Object.keys(statsData);
                    const incomingData = dates.map(date => statsData[date].incoming);
                    const outgoingData = dates.map(date => statsData[date].outgoing);

                    const chartOptions = {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: true,
                                mode: 'index',
                                intersect: false,
                                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                padding: 10,
                                displayColors: false,
                                callbacks: {
                                    title: function(tooltipItems) {
                                        return tooltipItems[0].label;
                                    },
                                    label: function(context) {
                                        let label = '';
                                        if (context.dataset.label === 'الكتب الواردة') {
                                            label = 'عدد الكتب الواردة: ';
                                        } else {
                                            label = 'عدد الكتب الصادرة: ';
                                        }
                                        return label + context.parsed.y;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                display: false,
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                display: false,
                                beginAtZero: true,
                                grid: {
                                    display: false
                                },
                                suggestedMax: Math.max(...incomingData, ...outgoingData) + 2 // إضافة مساحة أعلى
                            }
                        },
                        layout: {
                            padding: {
                                left: 10,
                                right: 10,
                                top: 10,
                                bottom: 10
                            }
                        }
                    };

                    // مخطط الكتب الواردة
                    const incomingCtx = document.getElementById('incomingChart');
                    if (incomingCtx) {
                        new Chart(incomingCtx, {
                            type: 'line',
                            data: {
                                labels: dates,
                                datasets: [{
                                    label: 'الكتب الواردة',
                                    data: incomingData,
                                    borderColor: '#696cff',
                                    backgroundColor: 'rgba(105, 108, 255, 0.1)',
                                    fill: true,
                                    tension: 0.4,
                                    pointRadius: 2,
                                    pointHoverRadius: 6,
                                    pointBackgroundColor: '#696cff'
                                }]
                            },
                            options: chartOptions
                        });
                    }

                    // مخطط الكتب الصادرة
                    const outgoingCtx = document.getElementById('outgoingChart');
                    if (outgoingCtx) {
                        new Chart(outgoingCtx, {
                            type: 'line',
                            data: {
                                labels: dates,
                                datasets: [{
                                    label: 'الكتب الصادرة',
                                    data: outgoingData,
                                    borderColor: '#71dd37',
                                    backgroundColor: 'rgba(113, 221, 55, 0.1)',
                                    fill: true,
                                    tension: 0.4,
                                    pointRadius: 2,
                                    pointHoverRadius: 6,
                                    pointBackgroundColor: '#71dd37'
                                }]
                            },
                            options: chartOptions
                        });
                    }
                });
            </script>
        @endpush
    @else
        <div class="container-xxl">
            <div class="misc-wrapper">
                <div class="card shadow-lg border-0">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <i class="mdi mdi-shield-lock-outline text-primary fs-1" style="opacity: 0.9;"></i>
                        </div>
                        <h2 class="mb-3 fw-semibold">عذراً! ليس لديك صلاحيات الوصول</h2>
                        <p class="mb-4 mx-auto text-muted" style="max-width: 500px;">
                            لا تملك الصلاحيات الكافية للوصول إلى هذه الصفحة. يرجى التواصل مع مدير النظام للحصول على
                            المساعدة.
                        </p>
                        <a href="{{ route('Dashboard') }}"
                            class="btn btn-primary btn-lg rounded-pill px-5 waves-effect waves-light">
                            <i class="mdi mdi-home-outline me-1"></i>
                            العودة إلى الرئيسية
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endcan
</div>
