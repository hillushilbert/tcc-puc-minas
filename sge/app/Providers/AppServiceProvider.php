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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->app->bind(
            'App\Application\Interfaces\IStoreEntrega',
            'App\Application\StoreEntrega'
        );

        $this->app->bind(
            'App\Http\Interfaces\IEntregaRepository',
            'App\Http\Repository\EntregaRepository'
        );

        $this->app->bind(
            'App\Http\Interfaces\IRoteiroRepository',
            'App\Http\Repository\RoteiroRepository'
        );
    }
}
