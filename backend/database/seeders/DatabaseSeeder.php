<?php

namespace Database\Seeders;

use App\Families\Infrastructure\Persistence\Models\EloquentFamily;
use App\Products\Infrastructure\Persistence\Models\EloquentProduct;
use App\Restaurants\Infrastructure\Persistence\Models\EloquentRestaurant;
use App\Taxes\Infrastructure\Persistence\Models\EloquentTax;
use App\User\Infrastructure\Persistence\Models\EloquentUser;
use App\Zones\Infrastructure\Persistence\Models\EloquentZone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $restaurants = EloquentRestaurant::factory()->count(3)->create();
        $families = EloquentFamily::factory()->recycle($restaurants)->count(10)->create();
        $users = EloquentUser::factory()->recycle($restaurants)->count(5)->create();
        $taxes = EloquentTax::factory()->recycle($restaurants)->count(4)->create();
        $products = EloquentProduct::factory()->recycle($restaurants)->recycle($families)->recycle($taxes)->count(50)->create();
        $zones = EloquentZone::factory()->recycle($restaurants)->count(8)->create();
    }
}
