<?php

namespace Database\Seeders;

use App\Families\Infrastructure\Persistence\Models\EloquentFamily;
use App\Order_lines\Infrastructure\Persistence\Models\EloquentOrderLine;
use App\Orders\Infrastructure\Persistence\Models\EloquentOrder;
use App\Products\Infrastructure\Persistence\Models\EloquentProduct;
use App\Restaurants\Infrastructure\Persistence\Models\EloquentRestaurant;
use App\Tables\Infrastructure\Persistence\Models\EloquentTable;
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
        $tables = EloquentTable::factory()->recycle($restaurants)->recycle($zones)->count(20)->create();
        $orders = EloquentOrder::factory()->recycle($restaurants)->recycle($tables)->recycle($users)->recycle($users)->count(50)->create();
        $order_lines = EloquentOrderLine::factory()->recycle($restaurants)->recycle($orders)->recycle($products)->recycle($users)->count(random_int(5, 50))->create();
    }
}
