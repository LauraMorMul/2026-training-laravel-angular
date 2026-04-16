<?php

namespace Database\Seeders;

use App\Tax\Infrastructure\Persistence\Models\EloquentTax;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Collection $restaurants): Collection
    {
        return
        EloquentTax::factory()
        ->recycle($restaurants)
        ->count(4)
        ->create();
    }
}
