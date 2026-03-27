<?php

namespace Database\Seeders;

use App\Sales\Infrastructure\Persistence\Models\EloquentSale;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Collection $restaurants, $orders, $users): Collection
    {
        return
        EloquentSale::factory()
        ->recycle($restaurants)
        ->recycle($orders)
        ->recycle($users)
        ->count(100)
        ->create();
    }
}
