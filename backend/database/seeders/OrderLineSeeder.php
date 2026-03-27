<?php

namespace Database\Seeders;

use App\Order_lines\Infrastructure\Persistence\Models\EloquentOrderLine;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class OrderLineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Collection $restaurants, $orders, $products, $users): Collection
    {
        return
        EloquentOrderLine::factory()
        ->recycle($restaurants)
        ->recycle($orders)
        ->recycle($products)
        ->recycle($users)
        ->count(random_int(5, 50))
        ->create();
    }
}
