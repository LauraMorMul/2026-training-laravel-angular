<?php

namespace Database\Seeders;

use App\Order\Infrastructure\Persistence\Models\EloquentOrder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Collection $restaurants, $tables, $users): Collection
    {
        return
        EloquentOrder::factory()
        ->recycle($restaurants)
        ->recycle($tables)
        ->recycle($users)
        ->count(50)
        ->create();
    }
}
