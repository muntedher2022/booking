<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // السماح بتسجيل الدخول عبر البريد الإلكتروني أو رقم الهاتف
        Fortify::authenticateUsing(function (Request $request) {
            $login = trim($request->input('email'));
            $cleanPhone = preg_replace('/[\s\-\+\(\)]/', '', $login);

            $user = \App\Models\User::where('email', $login)
                ->orWhere('phone', $login)
                ->orWhere('phone', $cleanPhone)
                ->when(strlen($cleanPhone) >= 7, function ($query) use ($cleanPhone) {
                    $trimmed = ltrim($cleanPhone, '0');
                    $query->orWhere('phone', 'like', "%{$trimmed}");
                })
                ->first();

            if ($user && \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
                return $user;
            }

            return null;
        });

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
