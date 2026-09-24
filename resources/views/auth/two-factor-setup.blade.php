@extends('layouts/layoutMaster')

@section('title', 'أمان الحساب - تطبيق المصادقة الثنائية (TOTP)')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y" style="direction: rtl;">

    <!-- Breadcrumb & Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #4f46e5;">
                <i class="mdi mdi-shield-check-outline me-2"></i>
                إعداد المصادقة الثنائية (TOTP)
            </h4>
            <p class="text-muted mb-0">حماية حسابك برمز إضافي يتم توليده عبر تطبيق هاتفك المحمول (Google أو Microsoft Authenticator)</p>
        </div>
        <a href="{{ route('Dashboard') }}" class="btn btn-outline-secondary">
            <i class="mdi mdi-arrow-right me-1"></i> العودة للرئيسية
        </a>
    </div>

    {{-- تنبيهات النجاح --}}
    @if (session('status') == 'two-factor-authentication-confirmed')
        <div class="alert alert-success alert-dismissible d-flex align-items-center mb-4" role="alert">
            <i class="mdi mdi-check-circle-outline fs-4 me-2"></i>
            <div>
                <strong>تهانينا!</strong> تم تفعيل وربط تطبيق المصادقة بحسابك بنجاح. سيُطلب منك إدخال الرمز من هاتفك عند كل عملية تسجيل دخول.
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session('status') == 'two-factor-authentication-disabled')
        <div class="alert alert-warning alert-dismissible d-flex align-items-center mb-4" role="alert">
            <i class="mdi mdi-alert-circle-outline fs-4 me-2"></i>
            <div>
                تم تعطيل تطبيق المصادقة الثنائية لحسابك بنجاح.
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session('status') == 'recovery-codes-regenerated')
        <div class="alert alert-info alert-dismissible d-flex align-items-center mb-4" role="alert">
            <i class="mdi mdi-information-outline fs-4 me-2"></i>
            <div>
                تمت إعادة توليد رموز الاسترداد الاحتياطية بنجاح. يرجى حفظها في مكان آمن.
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- تنبيهات الأخطاء العامة --}}
    @if (isset($errors) && $errors->any())
        <div class="alert alert-danger alert-dismissible mb-4" role="alert">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        @if (!$isConfirmed)
            {{-- حالة: لم يتم تفعيل التطبيق بعد (عرض الباركود والربط) --}}
            <div class="col-lg-7 col-md-12 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header border-bottom py-3" style="background: rgba(99, 102, 241, 0.04);">
                        <h5 class="card-title mb-0 fw-bold" style="color: #4f46e5;">
                            <i class="mdi mdi-qrcode-scan me-2"></i>
                            الخطوة 1: مسح رمز الاستجابة السريعة (QR Code)
                        </h5>
                    </div>
                    <div class="card-body text-center p-4">
                        <p class="text-muted mb-4" style="line-height: 1.7;">
                            افتح تطبيق <strong>Google Authenticator</strong> أو <strong>Microsoft Authenticator</strong> على هاتفك، ثم اضغط على زر الإضافة (<strong>+</strong>) واختر <strong>مسح رمز الاستجابة السريعة (Scan a QR code)</strong> ووجه الكاميرا إلى هذا الرمز:
                        </p>

                        {{-- وعاء رمز الـ QR --}}
                        <div class="d-inline-block p-3 bg-white rounded-3 shadow-sm border mb-4" style="max-width: 250px;">
                            {!! $qrCodeSvg !!}
                        </div>

                        {{-- خيار الإدخال اليدوي --}}
                        <div class="mt-2 text-start p-3 rounded" style="background-color: #f8fafc; border: 1px dashed #cbd5e1;">
                            <span class="d-block fw-bold text-dark mb-1" style="font-size: 0.88rem;">
                                <i class="mdi mdi-key-variant me-1 text-primary"></i> تعذر مسح الرمز؟ أدخل المفتاح يدوياً في التطبيق:
                            </span>
                            <div class="input-group mt-2">
                                <input type="text" class="form-control text-center font-monospace fw-bold" id="manualSecret" value="{{ $secret }}" readonly style="letter-spacing: 2px; background: #fff;">
                                <button class="btn btn-outline-primary" type="button" onclick="copySecretKey()">
                                    <i class="mdi mdi-content-copy me-1"></i> نسخ المفتاح
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-md-12 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header border-bottom py-3" style="background: rgba(16, 185, 129, 0.04);">
                        <h5 class="card-title mb-0 fw-bold text-success">
                            <i class="mdi mdi-numeric-6-box-multiple-outline me-2"></i>
                            الخطوة 2: تأكيد الرمز وتفعيل الربط
                        </h5>
                    </div>
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <p class="text-muted mb-3" style="line-height: 1.7;">
                                بعد مسح الرمز، سيظهر في هاتفك رمز تحقق مكون من <strong>6 أرقام</strong> يتغير كل 30 ثانية. أدخله هنا لتأكيد نجاح الربط:
                            </p>

                            <form action="{{ route('two-factor.confirm') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="code" class="form-label fw-bold">رمز التحقق المكون من 6 أرقام:</label>
                                    <input 
                                        type="text" 
                                        inputmode="numeric" 
                                        pattern="[0-9]*" 
                                        maxlength="6" 
                                        class="form-control form-control-lg text-center fw-bold font-monospace @error('code') is-invalid @enderror" 
                                        id="code" 
                                        name="code" 
                                        placeholder="123456" 
                                        style="font-size: 1.8rem; letter-spacing: 8px; direction: ltr;" 
                                        required 
                                        autofocus
                                    >
                                    @error('code')
                                        <div class="invalid-feedback text-start">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold shadow-sm" style="background: #4f46e5; border-color: #4f46e5;">
                                    <i class="mdi mdi-shield-check me-2"></i> تأكيد وتفعيل تطبيق المصادقة
                                </button>
                            </form>
                        </div>

                        <div class="mt-4 p-3 rounded" style="background: rgba(245, 158, 11, 0.08); border: 1px solid rgba(245, 158, 11, 0.2);">
                            <small class="text-warning-emphasis d-block">
                                <i class="mdi mdi-information me-1"></i>
                                بمجرد التأكيد، سيكون حسابك محمياً ولن يتمكن أي شخص من تسجيل الدخول حتى لو امتلك كلمة المرور إلا بوجود هاتفك.
                            </small>
                        </div>
                    </div>
                </div>
            </div>

        @else
            {{-- حالة: التطبيق مفعل ونشط بالفعل --}}
            <div class="col-lg-8 col-md-12 mb-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-lg me-3" style="width: 54px; height: 54px; background: rgba(16, 185, 129, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="mdi mdi-shield-check text-success fs-2"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-1 text-success">تطبيق المصادقة مفعل ونشط</h4>
                                <p class="text-muted mb-0">تم تأكيد وتفعيل تطبيق Google أو Microsoft Authenticator بنجاح على حسابك.</p>
                            </div>
                        </div>
                        <div class="p-3 rounded mb-3" style="background: rgba(16, 185, 129, 0.06); border: 1px solid rgba(16, 185, 129, 0.2);">
                            <span class="text-dark">
                                <i class="mdi mdi-check-bold text-success me-1"></i>
                                عند تسجيل الدخول القادم، يمكنك اختيار إدخال الرمز من تطبيق هاتفك مباشرة دون الحاجة لانتظار رسائل الواتساب أو البريد.
                            </span>
                        </div>
                    </div>
                </div>

                {{-- رموز الاسترداد الاحتياطية --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="mdi mdi-lock-outline me-2 text-primary"></i>
                            رموز الاسترداد الاحتياطية (Recovery Codes)
                        </h5>
                        <form action="{{ route('two-factor.recovery-codes') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-secondary">
                                <i class="mdi mdi-refresh me-1"></i> إعادة توليد الرموز
                            </button>
                        </form>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted" style="font-size: 0.9rem;">
                            احفظ هذه الرموز الاحتياطية في مكان آمن. يمكن استخدام كل رمز منها لمرة واحدة لتسجيل الدخول في حال فقدت هاتفك أو تعذر الوصول إلى تطبيق المصادقة.
                        </p>
                        <div class="p-3 bg-light rounded font-monospace" style="direction: ltr; text-align: center;">
                            <div class="row g-2">
                                @foreach ($recoveryCodes as $rCode)
                                    <div class="col-6 col-md-4">
                                        <span class="badge bg-white text-dark border p-2 w-100 fw-bold" style="font-size: 0.9rem;">{{ $rCode }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- منطقة الخطر: تعطيل تطبيق المصادقة --}}
                <div class="card shadow-sm border-0 border-danger">
                    <div class="card-header border-bottom py-3 bg-danger bg-opacity-10">
                        <h5 class="card-title mb-0 fw-bold text-danger">
                            <i class="mdi mdi-alert-octagon-outline me-2"></i>
                            تعطيل تطبيق المصادقة الثنائية
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted">
                            إذا كنت ترغب في فك ربط التطبيق أو تغييره إلى هاتف آخر، يرجى إدخال كلمة مرور حسابك الحالية للتعطيل:
                        </p>
                        <form action="{{ route('two-factor.disable') }}" method="POST" onsubmit="return confirm('هل أنت متأكد من رغبتك في تعطيل تطبيق المصادقة الثنائية؟');">
                            @csrf
                            @method('DELETE')
                            <div class="row g-3 align-items-center">
                                <div class="col-md-7">
                                    <input type="password" name="current_password" class="form-control" placeholder="كلمة المرور الحالية للتأكيد" required>
                                </div>
                                <div class="col-md-5">
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="mdi mdi-shield-off me-1"></i> تعطيل تطبيق المصادقة
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header border-bottom py-3">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="mdi mdi-help-circle-outline me-2 text-info"></i>
                            إرشادات الأمان
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <ul class="list-unstyled mb-0" style="line-height: 2;">
                            <li class="mb-3">
                                <i class="mdi mdi-check-circle text-success me-2"></i>
                                <strong>يعمل بدون إنترنت:</strong> التطبيق على هاتفك يولد الرموز حتى لو لم يتوفر اتصال بالشبكة.
                            </li>
                            <li class="mb-3">
                                <i class="mdi mdi-check-circle text-success me-2"></i>
                                <strong>تزامن الوقت:</strong> تأكد دائماً أن ساعة هاتفك مضبوطة على "التوقيت التلقائي من الشبكة".
                            </li>
                            <li class="mb-3">
                                <i class="mdi mdi-check-circle text-success me-2"></i>
                                <strong>النسخ الاحتياطي:</strong> تطبيق Microsoft Authenticator أو Google Authenticator يتيح لك مزامنة الرموز مع حسابك السحابي لتجنب فقدانها عند تبديل الهاتف.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function copySecretKey() {
    var copyText = document.getElementById("manualSecret");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value).then(function() {
        alert("✅ تم نسخ المفتاح السري بنجاح إلى الحافظة!");
    });
}
</script>
@endsection
