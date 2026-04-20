<?php

namespace Database\Seeders;

use App\Restaurant\Infrastructure\Persistence\Models\EloquentRestaurant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): Collection
    {
        return
        EloquentRestaurant::factory()
            ->count(3)
            ->create();
    }
}
