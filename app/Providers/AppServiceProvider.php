<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();

        // Model::preventLazyLoading(!app()->isProduction());

        // Blade::directive('myName', function () {
        //     return "nmk";
        // });
        // Blade::if('isAdmin', function ($x) {
        //     return $x == 'admin';
        // });

        Blade::if('admin', function () {
            return Auth::user()->role === 'admin';
        });

        Blade::if('notAuthor', function () {
            return Auth::user()->role !== "author";
        });
    }
}
