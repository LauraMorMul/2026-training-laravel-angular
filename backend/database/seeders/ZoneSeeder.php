<?php

namespace Database\Seeders;

use App\Zone\Infrastructure\Persistence\Models\EloquentZone;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Collection $restaurants): Collection
    {
        return
        EloquentZone::factory()
        ->recycle($restaurants)
        ->count(8)
        ->create();
    }
}
