@php
    $configData = Helper::appClasses();
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'التحقق الثنائي للمشرف')

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
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
        .method-tab {
            padding: 8px 16px;
            border-radius: 8px;
            border: 1px solid #d9dee3;
            background: #fff;
            color: #566a7f;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s;
        }
        .method-tab.active {
            background: #666cff;
            color: #fff;
            border-color: #666cff;
            box-shadow: 0 2px 6px rgba(102, 108, 255, 0.4);
        }
    </style>
@endsection

@section('content')
    <div class="authentication-wrapper authentication-cover">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="gap-2 auth-cover-brand d-flex align-items-center">
            <span class="app-brand-text demo text-heading fw-bold fs-3">نظام الإدارة</span>
        </a>

        <div class="m-0 authentication-inner row">
            <div class="px-4 py-4 d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-5 mx-auto" style="direction: rtl;">
                <div class="pt-5 mx-auto w-px-400 pt-lg-0 text-center">
                    
                    <div class="mb-3 d-flex justify-content-center">
                        <div style="width: 60px; height: 60px; border-radius: 50%; background: rgba(102, 108, 255, 0.1); color: #666cff; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                            🛡️
                        </div>
                    </div>

                    <h4 class="mb-2 fw-bold">التحقق الثنائي لتسجيل الدخول</h4>

                    @if($licenseChannel === 'all')
                    <!-- شريط التبديل بين الطرق المتاحة -->
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <button type="button" class="method-tab active" id="tab-whatsapp" onclick="switchMethod('whatsapp')">
                            📲✉️ رمز الواتساب / الإيميل
                        </button>
                        <button type="button" class="method-tab" id="tab-totp" onclick="switchMethod('totp')">
                            📱 تطبيق المصادقة
                        </button>
                    </div>
                    @endif

                    <div id="otp-info">
                        <div class="mb-2">
                            <span class="otp-badge" style="background: rgba(102, 108, 255, 0.12); color: #666cff; border: 1px solid rgba(102, 108, 255, 0.25);">
                                📲✉️ تم إرسال الرمز إلى الواتساب والبريد معاً
                            </span>
                        </div>
                        <p class="text-muted small mb-4">أدخل رمز التحقق المكون من 6 أرقام لتأكيد هويتك.</p>
                    </div>

                    <div id="totp-info" style="display: none;">
                        <div class="mb-2">
                            <span class="otp-badge" style="background: rgba(16, 185, 129, 0.12); color: #059669; border: 1px solid rgba(16, 185, 129, 0.25);">
                                📱 رمز تطبيق Google Authenticator
                            </span>
                        </div>
                        <p class="text-muted small mb-4">أدخل الرمز الحالي من تطبيق المصادقة على هاتفك.</p>
                    </div>

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

                    <form method="POST" action="{{ route('otp.verify.submit') }}" id="form-verify">
                        @csrf
                        <input type="hidden" name="method" id="input-method" value="whatsapp">

                        <div class="mb-4">
                            <input type="text" name="code" class="form-control otp-input @error('code') is-invalid @enderror"
                                   placeholder="******" maxlength="6" autofocus required pattern="[0-9]{6}">
                        </div>

                        <button type="submit" class="btn btn-primary d-grid w-100 mb-3" style="font-weight: 700; padding: 10px;">
                            تأكيد والدخول للنظام
                        </button>
                    </form>

                    <div id="resend-container">
                        <form method="POST" action="{{ route('otp.resend') }}">
                            @csrf
                            <p class="text-muted small mb-2">
                                لم يصلك الرمز؟
                                <button type="submit" class="btn btn-link p-0 text-primary fw-bold" id="btn-resend">
                                    إعادة إرسال الرمز
                                </button>
                                <span id="timer-text" class="text-muted">(بعد <span id="countdown">{{ $countdown }}</span> ثانية)</span>
                            </p>
                        </form>
                    </div>

                    <div class="mt-4 pt-2 border-top">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-secondary">
                                تسجيل الخروج والعودة
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        let countdown = {{ $countdown }};
        const countdownEl = document.getElementById('countdown');
        const timerText = document.getElementById('timer-text');
        const btnResend = document.getElementById('btn-resend');

        function updateTimer() {
            if (countdown > 0) {
                countdown--;
                if (countdownEl) countdownEl.innerText = countdown;
                if (btnResend) {
                    btnResend.disabled = true;
                    btnResend.style.opacity = '0.5';
                    btnResend.style.pointerEvents = 'none';
                }
            } else {
                if (timerText) timerText.style.display = 'none';
                if (btnResend) {
                    btnResend.disabled = false;
                    btnResend.style.opacity = '1';
                    btnResend.style.pointerEvents = 'auto';
                }
            }
        }
        setInterval(updateTimer, 1000);
        updateTimer();

        function switchMethod(method) {
            document.getElementById('input-method').value = method;
            const tabWa = document.getElementById('tab-whatsapp');
            const tabTotp = document.getElementById('tab-totp');
            const otpInfo = document.getElementById('otp-info');
            const totpInfo = document.getElementById('totp-info');
            const resendBox = document.getElementById('resend-container');

            if (method === 'totp') {
                tabTotp.classList.add('active');
                tabWa.classList.remove('active');
                otpInfo.style.display = 'none';
                totpInfo.style.display = 'block';
                if (resendBox) resendBox.style.display = 'none';
            } else {
                tabWa.classList.add('active');
                tabTotp.classList.remove('active');
                otpInfo.style.display = 'block';
                totpInfo.style.display = 'none';
                if (resendBox) resendBox.style.display = 'block';
            }
        }
    </script>
@endsection