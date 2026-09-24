<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyAdminOtp
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            $check = \App\Licensing\LicensingService::check();
            $adminOtpEnabled = $check['valid'] && ($check['license']['admin_otp_enabled'] ?? false);
            $isTotpRequired = $user && method_exists($user, 'isTotpRequired') && $user->isTotpRequired();

            $routeName = $request->route() ? $request->route()->getName() : '';

            $excludedRoutes = [
                'otp.verify',
                'otp.verify.submit',
                'otp.resend',
                'two-factor.setup',
                'two-factor.confirm',
                'two-factor.disable',
                'two-factor.recovery-codes',
                'profile.show',
                'logout',
            ];

            if (in_array($routeName, $excludedRoutes)) {
                return $next($request);
            }

            // 1. إذا كان الـ OTP أو الـ TOTP مطلوباً ولم يتم التحقق بعد في هذه الجلسة
            $hasTotp = $user && method_exists($user, 'hasTotpSetup') && $user->hasTotpSetup();
            if ($adminOtpEnabled || $hasTotp) {
                if (session('admin_otp_verified') !== true && session('totp_verified') !== true) {
                    \App\Services\AdminOtpService::generateAndSend($user, $request->ip(), force: false);
                    return redirect()->route('otp.verify');
                }
            }

            // 2. إذا كان المستخدم ملزماً بالمصادقة الثنائية ولم يقم بربط التطبيق بعد، نوجهه لموقع قراءة الباركود
            if ($isTotpRequired && !$user->hasTotpSetup()) {
                return redirect()->route('two-factor.setup')->with('warning', 'حسابك ملزم بالمصادقة الثنائية. يرجى مسح رمز الاستجابة السريعة (QR Code) وتأكيد الرمز للمتابعة.');
            }
        }

        return $next($request);
    }
}