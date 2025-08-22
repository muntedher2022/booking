<div>
    @can('dashboard-view')
        <!-- Add Importance Statistics Cards -->
        <div class="row mb-5 justify-content-center g-4">
            @php
                $importanceConfig = [
                    'عادي' => [
                        'icon' => 'mdi-file-document',
                        'color' => 'info',
                        'watermark' => 'normal',
                    ],
                    'عاجل' => [
                        'icon' => 'mdi-clock-fast',
                        'color' => 'warning',
                        'watermark' => 'urgent',
                    ],
                    'سري' => [
                        'icon' => 'mdi-shield-lock',
                        'color' => 'danger',
                        'watermark' => 'confidential',
                    ],
                    'سري للغاية' => [
                        'icon' => 'mdi-shield-alert',
                        'color' => 'dark',
                        'watermark' => 'top-secret',
                    ],
                ];
            @endphp

            @foreach ($importanceConfig as $type => $config)
                <div class="col-md-6 col-lg-3">
                    <div class="card backdrop-blur-sm border-0 shadow-lg hover-shadow-lg transition-all overflow-hidden">
                        <div class="position-absolute top-0 start-0 w-100 h-100">
                            <div class="watermark-image {{ $config['watermark'] }}"></div>
                        </div>
                        <div class="card-body position-relative p-4">
                            <div class="d-flex flex-column align-items-center text-{{ $config['color'] }}">
                                <div class="icon-wrapper mb-3 importance-{{ $config['color'] }}">
                                    <i class="mdi {{ $config['icon'] }} mdi-48px importance-icon-{{ $config['color'] }}"></i>
                                </div>
                                <h6 class="mb-3 fw-bold">{{ $type }}</h6>
                                <h3 class="fw-bold mb-2">{{ $importanceStats[$type]['total'] }}</h3>
                                <div class="trend-indicator-alt">
                                    <span class="fs-6">اليوم: {{ $importanceStats[$type]['today'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
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
                        <!-- Header -->
                        <div class="d-flex align-items-center mb-4 justify-content-center">
                            <div class="avatar-wrapper me-3">
                                <div class="avatar-circle primary">
                                    <i class="mdi mdi-email-arrow-left mdi-36px text-primary"></i>
                                </div>
                            </div>
                            <div class="text-center">
                                <h5 class="mb-1 fw-bold text-primary fs-4">الكتب الواردة</h5>
                                <small class="text-primary-subtle">إجمالي عدد الكتب الواردة</small>
                            </div>
                        </div>

                        <!-- Stats Content -->
                        <div class="text-center w-100">
                            <!-- Stats Row -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <!-- Internal Books (Right) -->
                                <div class="stats-detail primary-card flex-fill mx-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="stats-icon primary-light">
                                            <i class="mdi mdi-office-building mdi-24px text-primary"></i>
                                        </div>
                                        <div class="stats-info d-flex align-items-center gap-2">
                                            <h6 class="mb-0 text-primary-subtle">الكتب الداخلية</h6>
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
                                <div class="stats-detail primary-card flex-fill mx-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="stats-icon primary-light">
                                            <i class="mdi mdi-domain mdi-24px text-primary"></i>
                                        </div>
                                        <div class="stats-info d-flex align-items-center gap-2">
                                            <h6 class="mb-0 text-primary-subtle">الكتب الخارجية</h6>
                                            <span class="fs-4 fw-bold text-primary">{{ number_format($incomingExternalCount) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Trend Indicator -->
                            <div class="trend-indicator primary-card mt-2">
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

            <div class="col-md-8 col-lg-6">
                <div class="card backdrop-blur-sm border-0 shadow-lg hover-shadow-lg transition-all overflow-hidden">
                    <div class="position-absolute top-0 start-0 w-100 h-100">
                        <div class="watermark-image outgoing"></div>
                    </div>
                    <div class="card-body position-relative p-5">
                        <!-- Header -->
                        <div class="d-flex align-items-center mb-4 justify-content-center">
                            <div class="avatar-wrapper me-3">
                                <div class="avatar-circle success">
                                    <i class="mdi mdi-email-arrow-right mdi-36px text-success"></i>
                                </div>
                            </div>
                            <div class="text-center">
                                <h5 class="mb-1 fw-bold text-success fs-4">الكتب الصادرة</h5>
                                <small class="text-success-subtle">إجمالي عدد الكتب الصادرة</small>
                            </div>
                        </div>

                        <!-- Stats Content -->
                        <div class="text-center w-100">
                            <!-- Stats Row -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <!-- Internal Books (Right) -->
                                <div class="stats-detail success-card flex-fill mx-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="stats-icon success-light">
                                            <i class="mdi mdi-office-building mdi-24px text-success"></i>
                                        </div>
                                        <div class="stats-info d-flex align-items-center gap-2">
                                            <h6 class="mb-0 text-success-subtle">الكتب الداخلية</h6>
                                            <span class="fs-4 fw-bold text-success">{{ number_format($outgoingInternalCount) }}</span>
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
                                <div class="stats-detail success-card flex-fill mx-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="stats-icon success-light">
                                            <i class="mdi mdi-domain mdi-24px text-success"></i>
                                        </div>
                                        <div class="stats-info d-flex align-items-center gap-2">
                                            <h6 class="mb-0 text-success-subtle">الكتب الخارجية</h6>
                                            <span class="fs-4 fw-bold text-success">{{ number_format($outgoingExternalCount) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Trend Indicator -->
                            <div class="trend-indicator success-card mt-2">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <i class="mdi mdi-trending-up fs-4"></i>
                                    <div class="d-flex flex-column">
                                        <span class="fs-6 text-success">الكتب المضافة اليوم</span>
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

            .icon-wrapper {
                width: 80px;
                height: 80px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                background: rgba(var(--bs-primary-rgb), 0.1);
                transition: all 0.3s ease;
            }

            .text-info .icon-wrapper {
                background: rgba(var(--bs-info-rgb), 0.1);
            }

            .text-warning .icon-wrapper {
                background: rgba(var(--bs-warning-rgb), 0.1);
            }

            .text-danger .icon-wrapper {
                background: rgba(var(--bs-danger-rgb), 0.1);
            }

            .text-dark .icon-wrapper {
                background: rgba(var(--bs-dark-rgb), 0.1);
            }

            .card:hover .icon-wrapper {
                transform: scale(1.1);
            }

            /* تأثيرات حيوية متقدمة لأيقونات درجات الأهمية */

            /* أيقونة عادي - تأثير نبض هادئ */
            .importance-icon-info {
                animation: gentlePulse 3s ease-in-out infinite;
            }

            .icon-wrapper.importance-info {
                position: relative;
                overflow: visible;
            }

            .icon-wrapper.importance-info::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 100%;
                height: 100%;
                border-radius: 50%;
                background: rgba(13, 202, 240, 0.3);
                animation: rippleInfo 2s infinite;
            }

            @keyframes gentlePulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.05); }
            }

            @keyframes rippleInfo {
                0% {
                    transform: translate(-50%, -50%) scale(0.8);
                    opacity: 1;
                }
                100% {
                    transform: translate(-50%, -50%) scale(1.4);
                    opacity: 0;
                }
            }

            /* أيقونة عاجل - تأثير اهتزاز وتوهج */
            .importance-icon-warning {
                animation: urgentShake 0.8s ease-in-out infinite, urgentGlow 2s ease-in-out infinite;
                filter: drop-shadow(0 0 8px rgba(255, 193, 7, 0.5));
            }

            .icon-wrapper.importance-warning {
                position: relative;
                overflow: visible;
            }

            .icon-wrapper.importance-warning::before {
                content: '';
                position: absolute;
                top: -10px;
                left: -10px;
                right: -10px;
                bottom: -10px;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(255, 193, 7, 0.4) 0%, transparent 70%);
                animation: warningPulse 1s ease-in-out infinite;
            }

            @keyframes urgentShake {
                0%, 100% { transform: translateX(0) rotate(0deg); }
                25% { transform: translateX(-2px) rotate(-1deg); }
                75% { transform: translateX(2px) rotate(1deg); }
            }

            @keyframes urgentGlow {
                0%, 100% { filter: drop-shadow(0 0 8px rgba(255, 193, 7, 0.5)); }
                50% { filter: drop-shadow(0 0 20px rgba(255, 193, 7, 0.8)); }
            }

            @keyframes warningPulse {
                0%, 100% {
                    transform: scale(1);
                    opacity: 0.6;
                }
                50% {
                    transform: scale(1.2);
                    opacity: 0.3;
                }
            }

            /* أيقونة سري - تأثير اهتزاز خفيف وتوهج أحمر */
            .importance-icon-danger {
                animation: dangerGlow 1.5s ease-in-out infinite, secretShake 3s ease-in-out infinite;
                filter: drop-shadow(0 0 10px rgba(220, 53, 69, 0.6));
            }

            .icon-wrapper.importance-danger {
                position: relative;
                overflow: visible;
            }

            .icon-wrapper.importance-danger::before,
            .icon-wrapper.importance-danger::after {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                border-radius: 50%;
                animation: dangerRipple 2s infinite;
            }

            .icon-wrapper.importance-danger::before {
                width: 120%;
                height: 120%;
                background: rgba(220, 53, 69, 0.2);
                animation-delay: 0s;
            }

            .icon-wrapper.importance-danger::after {
                width: 140%;
                height: 140%;
                background: rgba(220, 53, 69, 0.1);
                animation-delay: 0.5s;
            }

            @keyframes secretShake {
                0%, 100% { transform: translateX(0) translateY(0) rotate(0deg); }
                25% { transform: translateX(-1px) translateY(-1px) rotate(-2deg); }
                50% { transform: translateX(1px) translateY(1px) rotate(1deg); }
                75% { transform: translateX(-1px) translateY(1px) rotate(-1deg); }
            }

            @keyframes dangerGlow {
                0%, 100% { filter: drop-shadow(0 0 10px rgba(220, 53, 69, 0.6)); }
                50% { filter: drop-shadow(0 0 25px rgba(220, 53, 69, 0.9)); }
            }

            @keyframes dangerRipple {
                0% {
                    transform: translate(-50%, -50%) scale(0.5);
                    opacity: 0.8;
                }
                100% {
                    transform: translate(-50%, -50%) scale(1.5);
                    opacity: 0;
                }
            }

            /* أيقونة سري للغاية - تأثير متقدم مع ومضات */
            .importance-icon-dark {
                animation: topSecretFlash 0.5s ease-in-out infinite alternate,
                           darkPulse 2s ease-in-out infinite,
                           darkSway 4s ease-in-out infinite;
                filter: drop-shadow(0 0 15px rgba(33, 37, 41, 0.8));
            }            .icon-wrapper.importance-dark {
                position: relative;
                overflow: visible;
                background: radial-gradient(circle, rgba(33, 37, 41, 0.15) 0%, rgba(33, 37, 41, 0.05) 70%);
            }

            .icon-wrapper.importance-dark::before {
                content: '';
                position: absolute;
                top: -15px;
                left: -15px;
                right: -15px;
                bottom: -15px;
                border-radius: 50%;
                background:
                    radial-gradient(circle at 30% 30%, rgba(33, 37, 41, 0.4) 0%, transparent 50%),
                    radial-gradient(circle at 70% 70%, rgba(33, 37, 41, 0.3) 0%, transparent 50%);
                animation: darkAura 3s ease-in-out infinite;
            }

            @keyframes topSecretFlash {
                0% { opacity: 0.8; transform: scale(1); }
                100% { opacity: 1; transform: scale(1.02); }
            }

            @keyframes darkPulse {
                0%, 100% {
                    filter: drop-shadow(0 0 15px rgba(33, 37, 41, 0.8));
                    transform: scale(1);
                }
                50% {
                    filter: drop-shadow(0 0 30px rgba(33, 37, 41, 1));
                    transform: scale(1.05);
                }
            }

            @keyframes darkSway {
                0%, 100% { transform: translateX(0) translateY(0) rotate(0deg); }
                25% { transform: translateX(-2px) translateY(-1px) rotate(-3deg); }
                50% { transform: translateX(2px) translateY(2px) rotate(2deg); }
                75% { transform: translateX(-1px) translateY(1px) rotate(-1deg); }
            }

            @keyframes darkAura {
                0%, 100% {
                    opacity: 0.3;
                    transform: rotate(0deg) scale(1);
                }
                50% {
                    opacity: 0.6;
                    transform: rotate(180deg) scale(1.1);
                }
            }

            /* تأثيرات إضافية عند التحويم على البطاقات */
            .card:hover .importance-icon-info {
                animation-duration: 1s;
            }

            .card:hover .importance-icon-warning {
                animation-duration: 0.3s, 1s;
            }

            .card:hover .importance-icon-danger {
                animation-duration: 2s, 0.8s;
            }

            .card:hover .importance-icon-dark {
                animation-duration: 0.2s, 1s, 4s;
            }

            /* تأثيرات الخلفية للبطاقات حسب نوع الأهمية */
            .card:has(.importance-info) {
                background: linear-gradient(145deg, rgba(13, 202, 240, 0.02) 0%, rgba(255, 255, 255, 0.98) 100%);
                border: 1px solid rgba(13, 202, 240, 0.1);
                position: relative;
                overflow: hidden;
            }

            .card:has(.importance-info)::before {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: linear-gradient(45deg, transparent, rgba(13, 202, 240, 0.03), transparent);
                animation: gradientRotate 8s linear infinite;
                z-index: 0;
            }

            .card:has(.importance-warning) {
                background: linear-gradient(145deg, rgba(255, 193, 7, 0.03) 0%, rgba(255, 255, 255, 0.98) 100%);
                border: 1px solid rgba(255, 193, 7, 0.2);
                position: relative;
                overflow: hidden;
            }

            .card:has(.importance-warning)::before {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: linear-gradient(45deg, transparent, rgba(255, 193, 7, 0.05), transparent);
                animation: gradientRotate 4s linear infinite;
                z-index: 0;
            }

            .card:has(.importance-danger) {
                background: linear-gradient(145deg, rgba(220, 53, 69, 0.03) 0%, rgba(255, 255, 255, 0.98) 100%);
                border: 1px solid rgba(220, 53, 69, 0.2);
                position: relative;
                overflow: hidden;
            }

            .card:has(.importance-danger)::before {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background:
                    radial-gradient(circle, rgba(220, 53, 69, 0.04) 0%, transparent 70%),
                    linear-gradient(45deg, transparent, rgba(220, 53, 69, 0.03), transparent);
                animation: gradientRotate 3s linear infinite, pulseGradient 2s ease-in-out infinite;
                z-index: 0;
            }

            .card:has(.importance-dark) {
                background: linear-gradient(145deg, rgba(33, 37, 41, 0.05) 0%, rgba(255, 255, 255, 0.95) 100%);
                border: 1px solid rgba(33, 37, 41, 0.3);
                position: relative;
                overflow: hidden;
            }

            .card:has(.importance-dark)::before {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background:
                    conic-gradient(from 0deg, transparent, rgba(33, 37, 41, 0.06), transparent, rgba(33, 37, 41, 0.04), transparent);
                animation: gradientRotate 6s linear infinite, darkPulseGradient 3s ease-in-out infinite;
                z-index: 0;
            }

            @keyframes gradientRotate {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

            @keyframes pulseGradient {
                0%, 100% { opacity: 0.3; }
                50% { opacity: 0.7; }
            }

            @keyframes darkPulseGradient {
                0%, 100% {
                    opacity: 0.2;
                    transform: rotate(0deg) scale(1);
                }
                50% {
                    opacity: 0.6;
                    transform: rotate(180deg) scale(1.1);
                }
            }

            /* ضمان أن محتوى البطاقة يظهر فوق التدرجات */
            .card-body {
                position: relative;
                z-index: 1;
            }

            /* تأثيرات الظل المحسنة عند التحويم */
            .card:has(.importance-info):hover {
                box-shadow: 0 15px 35px rgba(13, 202, 240, 0.25) !important;
            }

            .card:has(.importance-warning):hover {
                box-shadow: 0 15px 35px rgba(255, 193, 7, 0.3) !important;
            }

            .card:has(.importance-danger):hover {
                box-shadow: 0 15px 35px rgba(220, 53, 69, 0.3) !important;
            }

            .card:has(.importance-dark):hover {
                box-shadow: 0 15px 35px rgba(33, 37, 41, 0.4) !important;
            }

            /* تأثيرات الجسيمات والتألق */
            @keyframes sparkle {
                0%, 100% {
                    opacity: 0;
                    transform: scale(0) rotate(0deg);
                }
                50% {
                    opacity: 1;
                    transform: scale(1) rotate(180deg);
                }
            }

            .importance-warning::after {
                content: '✨';
                position: absolute;
                top: -5px;
                right: -5px;
                font-size: 12px;
                animation: sparkle 2s ease-in-out infinite;
                animation-delay: 0.5s;
            }

            .importance-danger::after {
                content: '⚡';
                position: absolute;
                top: -8px;
                right: -8px;
                font-size: 14px;
                animation: sparkle 1.5s ease-in-out infinite;
                animation-delay: 0.3s;
            }

            .importance-dark::after {
                content: '🔒';
                position: absolute;
                top: -10px;
                right: -10px;
                font-size: 10px;
                animation: sparkle 3s ease-in-out infinite;
                animation-delay: 1s;
            }

            /* تأثير البريق المتحرك */
            @keyframes shimmer {
                0% { transform: translateX(-100%); }
                100% { transform: translateX(100%); }
            }

            .icon-wrapper.importance-warning::before {
                background:
                    linear-gradient(90deg,
                        transparent,
                        rgba(255, 193, 7, 0.4),
                        transparent
                    );
                animation: shimmer 2s ease-in-out infinite, warningPulse 1s ease-in-out infinite;
            }

            /* تأثير الطاقة النابضة للسري */
            .icon-wrapper.importance-danger::before {
                background:
                    radial-gradient(circle,
                        rgba(220, 53, 69, 0.3) 0%,
                        rgba(220, 53, 69, 0.1) 40%,
                        transparent 70%
                    );
                animation: dangerRipple 2s infinite, energyPulse 1s ease-in-out infinite;
            }

            @keyframes energyPulse {
                0%, 100% {
                    filter: blur(0px);
                    transform: translate(-50%, -50%) scale(0.8);
                }
                50% {
                    filter: blur(2px);
                    transform: translate(-50%, -50%) scale(1.2);
                }
            }

            /* تأثير الضباب للسري للغاية */
            .icon-wrapper.importance-dark::after {
                background:
                    radial-gradient(circle,
                        rgba(33, 37, 41, 0.2) 0%,
                        rgba(33, 37, 41, 0.1) 30%,
                        transparent 60%
                    );
                filter: blur(3px);
                animation: darkAura 3s ease-in-out infinite, mistEffect 4s linear infinite;
            }

            @keyframes mistEffect {
                0%, 100% {
                    opacity: 0.2;
                    filter: blur(3px);
                }
                50% {
                    opacity: 0.5;
                    filter: blur(1px);
                }
            }

            /* تأثيرات الحركة المتقدمة عند التحميل */
            .importance-info {
                animation-delay: 0.1s;
            }

            .importance-warning {
                animation-delay: 0.2s;
            }

            .importance-danger {
                animation-delay: 0.3s;
            }

            .importance-dark {
                animation-delay: 0.4s;
            }

            /* تأثير التلاشي والظهور عند التحميل */
            @keyframes fadeInScale {
                0% {
                    opacity: 0;
                    transform: scale(0.3) rotate(-10deg);
                }
                100% {
                    opacity: 1;
                    transform: scale(1) rotate(0deg);
                }
            }

            .icon-wrapper {
                animation: fadeInScale 0.8s ease-out;
            }

            /* تحسينات الأداء */
            .importance-icon-info,
            .importance-icon-warning,
            .importance-icon-danger,
            .importance-icon-dark {
                will-change: transform, filter;
                backface-visibility: hidden;
                perspective: 1000px;
            }

            /* تأثيرات التحريك ثلاثي الأبعاد */
            .card:hover .icon-wrapper.importance-info {
                transform: perspective(100px) rotateX(15deg) rotateY(15deg) scale(1.1);
            }

            .card:hover .icon-wrapper.importance-warning {
                transform: perspective(100px) rotateX(-10deg) rotateY(10deg) scale(1.15);
            }

            .card:hover .icon-wrapper.importance-danger {
                transform: perspective(100px) rotateX(10deg) rotateY(-15deg) scale(1.1);
            }

            .card:hover .icon-wrapper.importance-dark {
                transform: perspective(100px) rotateX(-15deg) rotateY(-10deg) scale(1.2);
            }

            .trend-indicator-alt {
                padding: 0.5rem 1rem;
                border-radius: 1rem;
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(5px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .text-info .trend-indicator-alt {
                background: rgba(var(--bs-info-rgb), 0.1);
            }

            .text-warning .trend-indicator-alt {
                background: rgba(var(--bs-warning-rgb), 0.1);
            }

            .text-danger .trend-indicator-alt {
                background: rgba(var(--bs-danger-rgb), 0.1);
            }

            .text-dark .trend-indicator-alt {
                background: rgba(var(--bs-dark-rgb), 0.1);
            }

            /* Primary Theme */
            .primary-card {
                background: rgba(105, 108, 255, 0.05);
                border-color: rgba(105, 108, 255, 0.1);
            }

            .primary-light {
                background: rgba(105, 108, 255, 0.1);
            }

            .text-primary-subtle {
                color: rgba(105, 108, 255, 0.7);
            }

            /* Success Theme */
            .success-card {
                background: rgba(113, 221, 55, 0.05);
                border-color: rgba(113, 221, 55, 0.1);
            }

            .success-light {
                background: rgba(113, 221, 55, 0.1);
            }

            .text-success-subtle {
                color: rgba(113, 221, 55, 0.7);
            }

            /* Card Hover Effects */
            .stats-detail.primary-card:hover {
                background: rgba(105, 108, 255, 0.1);
            }

            .stats-detail.success-card:hover {
                background: rgba(113, 221, 55, 0.1);
            }

            /* Animations */
            .stats-icon i {
                transition: transform 0.3s ease;
            }

            .stats-detail:hover .stats-icon i {
                transform: scale(1.2);
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

                // تأثيرات تفاعلية للأيقونات
                const importanceCards = document.querySelectorAll('.card:has([class*="importance-"])');

                importanceCards.forEach(card => {
                    const iconWrapper = card.querySelector('.icon-wrapper');
                    const importanceType = Array.from(iconWrapper.classList).find(cls => cls.startsWith('importance-'));

                    // إضافة تأثير النقر
                    card.addEventListener('click', () => {
                        iconWrapper.style.animation = 'none';

                        if (importanceType === 'importance-warning') {
                            iconWrapper.style.animation = 'urgentShake 0.1s ease-in-out 5, urgentGlow 2s ease-in-out infinite';
                        } else if (importanceType === 'importance-danger') {
                            iconWrapper.style.animation = 'secretShake 0.2s ease-in-out 8, dangerGlow 1.5s ease-in-out infinite';
                        } else if (importanceType === 'importance-dark') {
                            iconWrapper.style.animation = 'topSecretFlash 0.1s ease-in-out 10 alternate, darkPulse 2s ease-in-out infinite, darkSway 1s ease-in-out infinite';
                        } else {
                            iconWrapper.style.animation = 'gentlePulse 0.5s ease-in-out 3';
                        }

                        // إعادة تعيين الأنيميشن بعد فترة
                        setTimeout(() => {
                            iconWrapper.style.animation = '';
                        }, 2000);
                    });

                    // تأثير التحويم المحسن
                    card.addEventListener('mouseenter', () => {
                        const icon = iconWrapper.querySelector('i');
                        icon.style.transform = 'scale(1.2) rotate(10deg)';
                        icon.style.transition = 'all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55)';

                        // إضافة ذبذبة خفيفة
                        if (importanceType === 'importance-warning') {
                            card.style.animation = 'shake 0.5s ease-in-out';
                        }
                    });

                    card.addEventListener('mouseleave', () => {
                        const icon = iconWrapper.querySelector('i');
                        icon.style.transform = 'scale(1) rotate(0deg)';
                        card.style.animation = '';
                    });
                });

                // إنشاء جسيمات متحركة للسري للغاية
                const darkCards = document.querySelectorAll('.importance-dark');
                darkCards.forEach(darkIcon => {
                    createFloatingParticles(darkIcon.parentElement);
                });

                // دالة إنشاء الجسيمات
                function createFloatingParticles(container) {
                    const particles = ['•', '⋆', '✦', '◦', '∘'];

                    setInterval(() => {
                        const particle = document.createElement('div');
                        particle.textContent = particles[Math.floor(Math.random() * particles.length)];
                        particle.style.position = 'absolute';
                        particle.style.color = 'rgba(33, 37, 41, 0.3)';
                        particle.style.fontSize = Math.random() * 8 + 4 + 'px';
                        particle.style.pointerEvents = 'none';
                        particle.style.zIndex = '0';

                        // موضع عشوائي
                        particle.style.left = Math.random() * 100 + '%';
                        particle.style.top = '100%';

                        container.appendChild(particle);

                        // حركة الجسيم
                        let position = 100;
                        const speed = Math.random() * 2 + 1;
                        const drift = (Math.random() - 0.5) * 2;

                        const animateParticle = () => {
                            position -= speed;
                            particle.style.top = position + '%';
                            particle.style.transform = `translateX(${Math.sin(position / 10) * drift * 10}px)`;
                            particle.style.opacity = position / 100;

                            if (position > -10) {
                                requestAnimationFrame(animateParticle);
                            } else {
                                container.removeChild(particle);
                            }
                        };

                        requestAnimationFrame(animateParticle);
                    }, 3000);
                }

                // إضافة CSS للاهتزاز
                if (!document.querySelector('#shake-animation')) {
                    const style = document.createElement('style');
                    style.id = 'shake-animation';
                    style.textContent = `
                        @keyframes shake {
                            0%, 100% { transform: translateX(0) translateY(-5px); }
                            25% { transform: translateX(-2px) translateY(-3px); }
                            75% { transform: translateX(2px) translateY(-7px); }
                        }
                    `;
                    document.head.appendChild(style);
                }
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
                                        <th class="border-0 px-4 text-center">رقم الكتاب</th>
                                        <th class="border-0 text-center">التاريخ</th>
                                        <th class="border-0 text-center">الموضوع</th>
                                        <th class="border-0 text-center">النوع</th>
                                        <th class="border-0 text-center">الأهمية</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentBooks as $book)
                                        <tr>
                                            <td class="px-4 text-center">{{ $book->book_number }}</td>
                                            <td class="text-center">{{ Carbon\Carbon::parse($book->book_date)->format('Y-m-d') }}</td>
                                            <td class="text-center">{{ Str::limit($book->subject, 30) }}</td>
                                            <td class="text-center">
                                                <span
                                                    class="badge bg-{{ $book->book_type == 'وارد' ? 'soft-primary' : 'soft-success' }} rounded-pill px-3">
                                                    {{ $book->book_type }}
                                                </span>
                                            </td>
                                            <td class="text-center">
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
