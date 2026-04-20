<?php

namespace Database\Seeders;

use App\Product\Infrastructure\Persistence\Models\EloquentProduct;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Collection $restaurants, $families, $taxes): Collection
    {
        return
        EloquentProduct::factory()
            ->recycle($restaurants)
            ->recycle($families)
            ->recycle($taxes)
            ->count(50)
            ->create();
    }
}
