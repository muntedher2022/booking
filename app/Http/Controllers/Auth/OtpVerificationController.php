<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class OtpVerificationController extends Controller
{
    public function show()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (session('admin_otp_verified') === true) {
            return redirect()->intended('/');
        }

        $expires = session('admin_otp_expires');
        $countdown = 300;
        if ($expires) {
            $diff = now()->diffInSeconds($expires, false);
            $countdown = $diff > 0 ? (int)$diff : 0;
        }

        $channel = session('admin_otp_channel', 'both');

        return view('auth.otp-verify', [
            'countdown' => $countdown,
            'channel'   => $channel,
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $sessionOtp = session('admin_otp');
        $expires = session('admin_otp_expires');

        if (!$sessionOtp || now()->isAfter($expires)) {
            return back()->withErrors(['code' => 'انتهت صلاحية رمز التحقق. يرجى طلب رمز جديد.']);
        }

        if (trim($request->input('code')) === (string)$sessionOtp) {
            session(['admin_otp_verified' => true]);
            return redirect()->intended('/');
        }

        return back()->withErrors(['code' => 'الرمز الذي أدخلته غير صحيح. يرجى المحاولة مرة أخرى.']);
    }

    public function resend(Request $request)
    {
        $user = auth()->user();
        if (!$user || (empty($user->email) && empty($user->phone))) {
            return back()->withErrors(['code' => 'لا يوجد رقم هاتف أو بريد إلكتروني مسجل في حسابك.']);
        }

        $otp = mt_rand(100000, 999999);
        $expires = now()->addMinutes(5);

        $hasPhone = !empty($user->phone);
        $hasEmail = !empty($user->email);

        $check = \App\Licensing\LicensingService::check();
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
            'admin_otp_expires' => $expires,
            'admin_otp_channel' => $channel,
        ]);

        $sentChannels = [];

        // 1. WhatsApp
        if (in_array($channel, ['whatsapp', 'both']) && $hasPhone) {
            try {
                $response = Http::timeout(5)->post('http://127.0.0.1:3333/send-otp', [
                    'phone'   => $user->phone,
                    'otp'     => $otp,
                    'project' => 'نظام ارشفة الصادر والوارد',
                ]);
                if ($response->successful()) {
                    $sentChannels[] = 'الواتساب';
                }
            } catch (\Exception $e) {
                Log::error('Booking Resend WhatsApp OTP failed: ' . $e->getMessage());
            }
        }

        // 2. Email
        if (in_array($channel, ['email', 'both']) && $hasEmail) {
            try {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(
                    new \App\Mail\UserOtpMail(
                        (string)$otp,
                        $request->ip(),
                        $user->name ?? 'المسؤول',
                        'نظام ارشفة الصادر والوارد'
                    )
                );
                $sentChannels[] = 'البريد الإلكتروني';
            } catch (\Exception $e) {
                Log::error('Booking Resend Email OTP failed: ' . $e->getMessage());
            }
        }

        $msg = !empty($sentChannels) 
            ? 'تم إرسال رمز تحقق جديد إلى ' . implode(' و ', $sentChannels) . '.'
            : 'تم تجديد الرمز بنجاح.';

        return back()->with('status', $msg);
    }
}
