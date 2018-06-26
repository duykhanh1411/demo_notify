<?php

namespace App\Providers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //KhanhHD: config interface
        $this->app->bind(
            'App\Models\Interfaces\IStaffInterface',
            'App\Models\Staff'
        );
        $this->app->bind(
            'App\Models\Interfaces\ICompanyInterface',
            'App\Models\Company'
        );
    }
}
