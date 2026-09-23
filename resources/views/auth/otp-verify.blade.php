@php
    $configData = Helper::appClasses();
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'التحقق الثنائي للمشرف')

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/FugazOne/FugazOne-font.css') }}">
    <style>
        .otp-input {
            text-align: center;
            font-size: 26px;
            letter-spacing: 10px;
            font-family: monospace;
            font-weight: 700;
            padding: 12px;
            direction: ltr;
        }
        .otp-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 700;
        }
    </style>
@endsection

@section('content')
    <div class="authentication-wrapper authentication-cover">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="gap-2 auth-cover-brand d-flex align-items-center">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/logo/GCPI.png') }}" class="rounded img-fluid" style="width: 90px;">
            </span>
            <span class="app-brand-text demo text-heading fw-bold fs-1">
                <span class="feqrah">GCPI</span>
                <h5 class="mb-2 fw-semibold text-center">موانيء العراق</h5>
            </span>
        </a>
        <!-- /Logo -->

        <div class="m-0 authentication-inner row">
            <!-- Form Area -->
            <div class="px-4 py-4 d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-5" style="direction: rtl;">
                <div class="pt-5 mx-auto w-px-400 pt-lg-0 text-center">
                    
                    <!-- Icon Shield -->
                    <div class="mb-3 d-flex justify-content-center">
                        <div style="width: 60px; height: 60px; border-radius: 50%; background: rgba(102, 108, 255, 0.1); color: #666cff; display: flex; align-items: center; justify-content: center;">
                            <i class="mdi mdi-shield-check-outline" style="font-size: 32px;"></i>
                        </div>
                    </div>

                    <h4 class="mb-2 fw-bold">التحقق الثنائي لتسجيل الدخول</h4>

                    @if($channel === 'whatsapp')
                        <div class="mb-2">
                            <span class="otp-badge" style="background: rgba(16, 185, 129, 0.12); color: #059669; border: 1px solid rgba(16, 185, 129, 0.25);">
                                📲 تم إرسال الرمز إلى الواتساب
                            </span>
                        </div>
                        <p class="text-muted small mb-4">أدخل رمز التحقق المكون من 6 أرقام المرسل إلى تطبيق الواتساب المعتمد.</p>
                    @elseif($channel === 'email')
                        <div class="mb-2">
                            <span class="otp-badge" style="background: rgba(56, 189, 248, 0.12); color: #0284c7; border: 1px solid rgba(56, 189, 248, 0.25);">
                                ✉️ تم إرسال الرمز إلى البريد الإلكتروني
                            </span>
                        </div>
                        <p class="text-muted small mb-4">أدخل رمز التحقق المكون من 6 أرقام المرسل إلى بريدك الإلكتروني المعتمد.</p>
                    @else
                        <div class="mb-2">
                            <span class="otp-badge" style="background: rgba(102, 108, 255, 0.12); color: #666cff; border: 1px solid rgba(102, 108, 255, 0.25);">
                                📲✉️ تم إرسال الرمز إلى الواتساب والبريد معاً
                            </span>
                        </div>
                        <p class="text-muted small mb-4">أدخل رمز التحقق المرسل إلى الواتساب والبريد الإلكتروني لتأكيد هويتك.</p>
                    @endif

                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible text-center py-2" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (isset($errors) && $errors->any())
                        <div class="alert alert-danger alert-dismissible text-center py-2" role="alert">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Form -->
                    <form method="POST" action="{{ route('otp.verify.submit') }}" class="mb-3">
                        @csrf
                        <div class="mb-4">
                            <input type="text" 
                                   id="code" 
                                   name="code" 
                                   class="form-control otp-input" 
                                   maxlength="6" 
                                   inputmode="numeric" 
                                   placeholder="******" 
                                   autofocus 
                                   required autocomplete="off">
                        </div>

                        <button type="submit" class="btn btn-primary d-grid w-100 py-2 fw-bold">
                            تأكيد الرمز والعبور
                        </button>
                    </form>

                    <!-- Footer / Resend / Countdown -->
                    <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center text-muted small">
                        <div>
                            الصلاحية: <span id="timerText" class="fw-bold text-primary">05:00</span>
                        </div>

                        <form method="POST" action="{{ route('otp.resend') }}" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 text-decoration-underline fw-semibold text-primary" style="font-size: 0.85rem;">
                                إعادة إرسال الرمز
                            </button>
                        </form>
                    </div>

                </div>
            </div>
            <!-- /Form Area -->

            <!-- Illustration Area -->
            <div class="p-3 pb-2 d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center">
                <img src="{{ asset('assets/img/illustrations/1688557739.png') }}"
                     class="auth-cover-illustration w-50" 
                     alt="auth-illustration">
            </div>
        </div>
    </div>

    <!-- Countdown Timer Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let seconds = {{ $countdown }};
            const timerEl = document.getElementById('timerText');

            function updateDisplay() {
                if (seconds <= 0) {
                    timerEl.textContent = 'منتهي';
                    timerEl.classList.remove('text-primary');
                    timerEl.classList.add('text-danger');
                    return;
                }
                let m = Math.floor(seconds / 60);
                let s = seconds % 60;
                timerEl.textContent = `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
                seconds--;
            }

            updateDisplay();
            setInterval(updateDisplay, 1000);
        });
    </script>
@endsection