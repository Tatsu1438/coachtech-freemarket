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
        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });

        $this->app->instance(LoginResponseContract::class, new LoginResponseController());
        $this->app->singleton(RegisterResponseContract::class, RegisterResponseController::class);

        $this->app->singleton(CreatesNewUsers::class, CreateNewUser::class);

    }
}