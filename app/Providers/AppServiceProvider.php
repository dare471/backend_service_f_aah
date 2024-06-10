<?php

namespace App\Providers;

use App\Http\Resources\Contact;
use App\Repositories\Baf\ContragentRepository;
use App\Repositories\Client\Contract\ContractRepository;
use App\Services\Client\OrderService;
use App\Services\ContragentService;
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
        $this->app->singleton(ContractRepository::class, function($app){
            return new ContractRepository();
        });

        $this->app->singleton(OrderService::class, function($app){
            return new OrderService($app->make(ContractRepository::class));
        });

        $this->app->singleton(ContragentRepository::class, function ($app){
            return new ContragentRepository();
        });

        $this->app->singleton(ContragentService::class, function ($app){
            return new ContragentService($app->make(ContragentRepository::class));
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
    }
}
