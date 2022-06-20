<?php

namespace App\Providers;

use App\Contracts\ICouponRepository;
use App\Contracts\IProductRepository;
use App\Repositories\CouponRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;

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
        JsonResource::withoutWrapping();
        $this->app->bind(ICouponRepository::class, CouponRepository::class);
        $this->app->bind(IProductRepository::class, ProductRepository::class);
    }
}
