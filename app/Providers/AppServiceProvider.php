<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //

        Inertia::share('admin', function () {
            if (session()->has('admin_id')) {
                return User::find(session()->get('admin_id'));
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Inertia::share('flash', function () {
            return [
                'success' => Session::get('success'),
                'error' => Session::get('error'),
            ];
        });
    }
}
