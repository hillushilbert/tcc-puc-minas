<?php

namespace App\Providers;

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
        $this->app->bind(
            'App\Application\Interfaces\IAuthToken',
            'App\Application\AuthToken'
        );
        
        $this->app->bind(
            'App\Application\Interfaces\IRefreshToken',
            'App\Application\RefreshToken'
        );
    }
}
