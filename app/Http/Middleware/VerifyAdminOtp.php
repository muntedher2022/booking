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
            $check = \App\Licensing\LicensingService::check();
            $adminOtpEnabled = $check['valid'] && ($check['license']['admin_otp_enabled'] ?? false);

            if (!$adminOtpEnabled) {
                return $next($request);
            }

            $routeName = $request->route() ? $request->route()->getName() : '';

            $excludedRoutes = [
                'otp.verify',
                'otp.verify.submit',
                'otp.resend',
                'logout',
            ];

            $isExcludedRoute = in_array($routeName, $excludedRoutes);

            if ($isExcludedRoute) {
                return $next($request);
            }

            if (session('admin_otp_verified') !== true) {
                $sessionOtp = session('admin_otp');
                $expires = session('admin_otp_expires');

                if (!$sessionOtp || now()->isAfter($expires)) {
                    $otp = mt_rand(100000, 999999);
                    $newExpires = now()->addMinutes(5);

                    $user = auth()->user();
                    $hasPhone = $user && !empty($user->phone);
                    $hasEmail = $user && !empty($user->email);

                    $licenseChannel = $check['license']['admin_otp_channel'] ?? 'both';
                    if ($licenseChannel === 'whatsapp' && $hasPhone) {
                        $channel = 'whatsapp';
                    } elseif ($licenseChannel === 'email' && $hasEmail) {
                        $channel = 'email';
                    } elseif ($licenseChannel === 'both') {
                        $channel = ($hasPhone && $hasEmail) ? 'both' : ($hasPhone ? 'whatsapp' : ($hasEmail ? 'email' : 'none'));
                    } else {
                        $channel = $hasPhone ? 'whatsapp' : ($hasEmail ? 'email' : 'none');
                    }

                    session([
                        'admin_otp' => $otp,
                        'admin_otp_expires' => $newExpires,
                        'admin_otp_channel' => $channel,
                    ]);

                    // 1. WhatsApp
                    if (in_array($channel, ['whatsapp', 'both']) && $hasPhone) {
                        try {
                            \Illuminate\Support\Facades\Http::timeout(5)->post('http://127.0.0.1:3333/send-otp', [
                                'phone'   => $user->phone,
                                'otp'     => $otp,
                                'project' => config('app.name', 'نظام الحجوزات') . " - {$user->name}",
                            ]);
                        } catch (\Exception $e) {
                            \Illuminate\Support\Facades\Log::error('Booking WhatsApp OTP failed: ' . $e->getMessage());
                        }
                    }

                    // 2. Email
                    if (in_array($channel, ['email', 'both']) && $hasEmail) {
                        try {
                            \Illuminate\Support\Facades\Mail::raw("رمز التحقق الثنائي الخاص بك لنظام " . config('app.name', 'نظام الحجوزات') . " هو: {$otp}", function ($message) use ($user) {
                                $message->to($user->email)
                                        ->subject('رمز التحقق الثنائي - ' . config('app.name', 'نظام الحجوزات'));
                            });
                        } catch (\Exception $e) {
                            \Illuminate\Support\Facades\Log::error('Booking Email OTP failed: ' . $e->getMessage());
                        }
                    }
                }

                return redirect()->route('otp.verify');
            }
        }

        return $next($request);
    }
}
