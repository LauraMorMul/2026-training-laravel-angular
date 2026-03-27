<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Restaurants\Infrastructure\Persistence\Models\EloquentRestaurant;
use Illuminate\Database\Eloquent\Collection;

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
