<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;

class TwoFactorSetupController extends Controller
{
    /**
     * عرض صفحة إعداد وقراءة باركود المصادقة الثنائية (TOTP).
     */
    public function show(Request $request)
    {
        $user = auth()->user();
        $google2fa = new Google2FA();

        $isConfirmed = $user->hasTotpSetup();
        $secret = null;
        $qrCodeSvg = null;
        $recoveryCodes = [];

        if ($isConfirmed) {
            if ($user->two_factor_recovery_codes) {
                try {
                    $recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true) ?: [];
                } catch (\Exception $e) {
                    $recoveryCodes = [];
                }
            }
        } else {
            // توليد رمز سري جديد أو استخدام الموجود غير المؤكد بعد
            if (!empty($user->two_factor_secret)) {
                try {
                    $secret = decrypt($user->two_factor_secret);
                } catch (\Exception $e) {
                    $secret = $google2fa->generateSecretKey();
                    $user->two_factor_secret = encrypt($secret);
                    $user->save();
                }
            } else {
                $secret = $google2fa->generateSecretKey();
                $user->two_factor_secret = encrypt($secret);
                $user->save();
            }

            // توليد رابط الـ otpauth ورسم كود الـ QR بدقة عالية
            $companyName = config('app.name', 'نظام الحجوزات');
            $qrUrl = $google2fa->getQRCodeUrl($companyName, $user->email, $secret);

            $renderer = new ImageRenderer(
                new RendererStyle(220, 1),
                new SvgImageBackEnd()
            );
            $writer = new Writer($renderer);
            $qrCodeSvg = $writer->writeString($qrUrl);
        }

        return view('auth.two-factor-setup', [
            'user'          => $user,
            'isConfirmed'   => $isConfirmed,
            'secret'        => $secret,
            'qrCodeSvg'     => $qrCodeSvg,
            'recoveryCodes' => $recoveryCodes,
        ]);
    }

    /**
     * تأكيد الرمز المكون من 6 أرقام وتفعيل تطبيق المصادقة.
     */
    public function confirm(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ], [
            'code.required' => 'حقل رمز التأكيد مطلوب.',
            'code.size'     => 'يجب أن يتكون رمز التأكيد من 6 أرقام تماماً.',
        ]);

        $user = auth()->user();
        if (empty($user->two_factor_secret)) {
            return back()->withErrors(['code' => 'لم يتم العثور على مفتاح سري للتطبيق. يرجى إعادة المحاولة.']);
        }

        try {
            $secret = decrypt($user->two_factor_secret);
            $google2fa = new Google2FA();
            $valid = $google2fa->verifyKey($secret, trim($request->input('code')), 2);
        } catch (\Exception $e) {
            $valid = false;
        }

        if (!$valid) {
            return back()->withErrors(['code' => 'الرمز المدخل غير صحيح. تأكد من إدخال الرمز المكون من 6 أرقام الظاهر حالياً في تطبيق المصادقة على هاتفك.']);
        }

        // توليد أكواد الاسترداد الاحتياطية
        $recoveryCodes = Collection::times(8, fn () => Str::random(10) . '-' . Str::random(10))->all();

        $user->forceFill([
            'two_factor_confirmed_at'   => now(),
            'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
        ])->save();

        session(['totp_verified' => true]);

        return redirect()->route('two-factor.setup')->with('status', 'two-factor-authentication-confirmed');
    }

    /**
     * تعطيل تطبيق المصادقة الثنائية.
     */
    public function disable(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
        ], [
            'current_password.required' => 'يرجى إدخال كلمة المرور الحالية للتأكيد.',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة.']);
        }

        $user->forceFill([
            'two_factor_secret'         => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at'   => null,
        ])->save();

        return redirect()->route('two-factor.setup')->with('status', 'two-factor-authentication-disabled');
    }

    /**
     * إعادة توليد أكواد الاسترداد.
     */
    public function regenerateRecoveryCodes(Request $request)
    {
        $user = auth()->user();
        if (!$user->hasTotpSetup()) {
            return redirect()->route('two-factor.setup');
        }

        $recoveryCodes = Collection::times(8, fn () => Str::random(10) . '-' . Str::random(10))->all();

        $user->forceFill([
            'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
        ])->save();

        return redirect()->route('two-factor.setup')->with('status', 'recovery-codes-regenerated');
    }
}
