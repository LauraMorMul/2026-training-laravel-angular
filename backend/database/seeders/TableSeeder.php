<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Tables\Infrastructure\Persistence\Models\EloquentTable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Collection $restaurants, $zones): Collection
    {
        return
        EloquentTable::factory()
        ->recycle($restaurants)
        ->recycle($zones)
        ->count(20)
        ->create();
    }
}
