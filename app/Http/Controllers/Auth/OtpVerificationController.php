<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AdminOtpService;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;

class OtpVerificationController extends Controller
{
    public function show(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (session('admin_otp_verified') === true || session('totp_verified') === true) {
            return redirect()->intended('/');
        }

        $user = auth()->user();
        $check = \App\Licensing\LicensingService::check();
        $adminOtpEnabled = $check['valid'] && ($check['license']['admin_otp_enabled'] ?? false);
        $hasTotpSetup = $user && method_exists($user, 'hasTotpSetup') && $user->hasTotpSetup();

        if (!$adminOtpEnabled && !$hasTotpSetup) {
            return redirect()->intended('/');
        }

        $licenseChannel = $adminOtpEnabled ? ($check['license']['admin_otp_channel'] ?? 'both') : 'totp';

        // التأكد من إرسال رمز التحقق إن لم يكن مرسلاً بعد
        if ($licenseChannel !== 'totp') {
            $sessionOtp = session('admin_otp');
            $expires = session('admin_otp_expires');
            if (!$sessionOtp || !session('admin_otp_dispatched_at') || now()->isAfter($expires)) {
                AdminOtpService::generateAndSend($user, $request->ip(), force: true);
            }
        }

        $expires = session('admin_otp_expires');
        $countdown = 300;
        if ($expires) {
            $diff = now()->diffInSeconds($expires, false);
            $countdown = $diff > 0 ? (int)$diff : 0;
        }

        $hasTotpSetup = $user && method_exists($user, 'hasTotpSetup') && $user->hasTotpSetup();

        return view('auth.otp-verify', [
            'countdown'      => $countdown,
            'channel'        => session('admin_otp_channel', 'both'),
            'licenseChannel' => $licenseChannel,
            'hasTotpSetup'   => $hasTotpSetup,
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code'   => 'required|string|size:6',
            'method' => 'nullable|string|in:whatsapp,totp',
        ]);

        $user = auth()->user();
        $code = trim($request->input('code'));
        $method = $request->input('method', 'whatsapp');

        // 1. التحقق عبر تطبيق المصادقة TOTP
        if ($method === 'totp') {
            if (!$user || !method_exists($user, 'hasTotpSetup') || !$user->hasTotpSetup()) {
                return back()->withErrors(['code' => 'لم تقم بربط تطبيق المصادقة بحسابك بعد. يرجى التحقق برمز الواتساب/البريد.']);
            }

            try {
                $google2fa = new Google2FA();
                $secret = decrypt($user->two_factor_secret);
                $valid = $google2fa->verifyKey($secret, $code, 8);
            } catch (\Exception $e) {
                $valid = false;
            }

            if ($valid) {
                session([
                    'admin_otp_verified' => true,
                    'totp_verified'      => true,
                ]);
                return redirect()->intended('/');
            }

            return back()->withErrors(['code' => 'رمز تطبيق المصادقة غير صحيح أو انتهت صلاحيته. يرجى المحاولة مجدداً.']);
        }

        // 2. التحقق عبر الواتساب والبريد الإلكتروني OTP
        $sessionOtp = session('admin_otp');
        $expires = session('admin_otp_expires');

        if (!$sessionOtp || now()->isAfter($expires)) {
            return back()->withErrors(['code' => 'انتهت صلاحية رمز التحقق. يرجى طلب رمز جديد.']);
        }

        if ($code === (string)$sessionOtp) {
            session([
                'admin_otp_verified' => true,
                'totp_verified'      => true,
            ]);
            return redirect()->intended('/');
        }

        return back()->withErrors(['code' => 'الرمز الذي أدخلته غير صحيح. يرجى المحاولة مرة أخرى.']);
    }

    public function resend(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return back()->withErrors(['code' => 'المستخدم غير موجود.']);
        }

        $result = AdminOtpService::generateAndSend($user, $request->ip(), force: true);

        if (!empty($result['channels'])) {
            return back()->with('status', 'تم إرسال رمز تحقق جديد بنجاح إلى ' . implode(' و ', $result['channels']) . '.');
        }

        return back()->withErrors(['code' => 'تعذر إرسال الرمز حالياً، يرجى مراجعة مسؤول النظام.']);
    }
}