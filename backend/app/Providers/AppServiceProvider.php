<?php

namespace App\Providers;

use App\Families\Domain\Interfaces\FamilyRepositoryInterface;
use App\User\Domain\Interfaces\PasswordHasherInterface;
use App\User\Domain\Interfaces\UserRepositoryInterface;
use App\User\Infrastructure\Persistence\Repositories\EloquentUserRepository;
use App\User\Infrastructure\Services\LaravelPasswordHasher;
use App\Families\Infrastructure\Persistence\Repositories\EloquentFamilyRepository;
use App\Products\Domain\Interfaces\ProductRepositoryInterface;
use App\Products\Infrastructure\Persistence\Repositories\EloquentProductRepository;
use App\Restaurants\Domain\Interfaces\RestaurantRepositoryInterface;
use App\Restaurants\Infrastructure\Persistence\Repositories\EloquentRestaurantRepository;
use App\Taxes\Domain\Interfaces\TaxRepositoryInterface;
use App\Taxes\Infrastructure\Persistence\Repositories\EloquentTaxRepository;
use App\Zones\Domain\Interfaces\ZoneRepositoryInterface;
use App\Zones\Infrastructure\Persistence\Repositories\EloquentZoneRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(PasswordHasherInterface::class, LaravelPasswordHasher::class);
        $this->app->bind(FamilyRepositoryInterface::class, EloquentFamilyRepository::class);
        $this->app->bind(RestaurantRepositoryInterface::class, EloquentRestaurantRepository::class);
        $this->app->bind(TaxRepositoryInterface::class, EloquentTaxRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, EloquentProductRepository::class);
        $this->app->bind(ZoneRepositoryInterface::class, EloquentZoneRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
