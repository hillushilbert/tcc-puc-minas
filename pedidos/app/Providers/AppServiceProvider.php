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
            'App\Http\Interfaces\IOrderRepository',
            'App\Http\Repository\OrderRepository'
        );

        $this->app->bind(
            'App\Http\Interfaces\ISupplierRepository',
            'App\Http\Repository\SupplierRepository'
        );

        $this->app->bind(
            'App\Http\Interfaces\IAdressRepository',
            'App\Http\Repository\AdressRepository'
        );

        $this->app->bind(
            'App\Http\Interfaces\ICustomerRepository',
            'App\Http\Repository\CustomerRepository'
        );

        $this->app->bind(
            'App\Application\Interfaces\IStoreOrder',
            'App\Application\StoreOrder'
        );        
        
        $this->app->bind(
            'App\Application\Interfaces\IListOrder',
            'App\Application\ListOrder'
        );

        $this->app->bind(
            'App\Application\Interfaces\IPublishNewOrder',
            'App\Application\PublishNewOrder'
        );

        $this->app->bind(
            'App\Application\Interfaces\IFindOrder',
            'App\Application\FindOrder'
        );

        $this->app->bind(
            'App\Application\Interfaces\IAuthToken',
            'App\Application\AuthToken'
        );
    }
}
