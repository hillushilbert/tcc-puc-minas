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
            'App\Http\Interfaces\IClientesRepository',
            'App\Http\Repository\ClientesRepository'
        );

        $this->app->bind(
            'App\Application\Interfaces\IClientesService',
            'App\Application\ClientesService'
        );

        $this->app->bind(
            'App\Application\Interfaces\IClientesSender',
            'App\Application\ClientesSender'
        );
    }
}
