<?php

namespace App\Providers;

use Carbon\Carbon;
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
        config(['app.locale' => 'id']);
	    Carbon::setLocale('id');
        Blade::directive('addMonth', function () {
            return Carbon::now()->addMonth()->format('F d, Y');
        });
        Blade::directive('formatedDate', function ($formatedDate) {
            return Carbon::parse($formatedDate)->translatedFormat('l, d F Y');
        });
    }
}
