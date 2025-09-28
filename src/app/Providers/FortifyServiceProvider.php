<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use App\Http\Controllers\Auth\LoginResponseController;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Actions\Fortify\CreateNewUser;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use App\Http\Controllers\Auth\RegisterResponseController;
use App\Http\Requests\LoginRequest;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \Laravel\Fortify\Http\Requests\LoginRequest::class,
            \App\Http\Requests\LoginRequest::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::authenticateUsing(function (\Illuminate\Http\Request $request) {

            $user = \App\Models\User::where('email', $request->email)->first();

            if (!$user) {
                throw ValidationException::withMessages([
                    'email' => ['ログイン情報が登録されていません'],
                ]);
            }

            if (!\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'password' => ['ログイン情報が登録されていません'],
                ]);
            }

            return $user;
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });

        RateLimiter::for('login', function ($request) {
            return Limit::perMinute(50);
        });

        $this->app->instance(LoginResponseContract::class, new LoginResponseController());
        $this->app->singleton(RegisterResponseContract::class, RegisterResponseController::class);

        $this->app->singleton(CreatesNewUsers::class, CreateNewUser::class);

    }
}