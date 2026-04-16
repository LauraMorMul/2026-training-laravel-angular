<?php

namespace Database\Seeders;

use App\Family\Infrastructure\Persistence\Models\EloquentFamily;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class FamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Collection $restaurants): Collection
    {
        return
        EloquentFamily::factory()
        ->recycle($restaurants)
        ->count(10)
        ->create();
    }
}
