<?php

namespace Database\Seeders;

use App\Sales_line\Infrastructure\Persistence\Models\EloquentSaleLine;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class SaleLineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Collection $restaurants, $sales, $orderLines, $users): Collection
    {
        return
        EloquentSaleLine::factory()
            ->recycle($restaurants)
            ->recycle($sales)
            ->recycle($orderLines)
            ->recycle($users)
            ->count(150)
            ->create();
    }
}
