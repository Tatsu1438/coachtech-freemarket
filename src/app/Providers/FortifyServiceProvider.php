<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use App\Http\Controllers\Auth\LoginResponseController;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Actions\Fortify\CreateNewUser;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // ログイン画面
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // 会員登録画面
        Fortify::registerView(function () {
            return view('auth.register');
        });

        // ログイン後のリダイレクト先をカスタマイズ
        $this->app->instance(LoginResponseContract::class, new LoginResponseController());
        $this->app->singleton(RegisterResponseContract::class, RegisterResponseController::class);

        $this->app->singleton(CreatesNewUsers::class, CreateNewUser::class);
    }
}