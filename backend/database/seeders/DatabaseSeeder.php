<?php

namespace Database\Seeders;

use App\Families\Infrastructure\Persistence\Models\EloquentFamily;
use App\Restaurants\Infrastructure\Persistence\Models\EloquentRestaurant;
use App\User\Infrastructure\Persistence\Models\EloquentUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $restaurants = EloquentRestaurant::factory()->count(3)->create();
        $families = EloquentFamily::factory()->recycle($restaurants)->count(10)->create();
        $users = EloquentUser::factory()->recycle($restaurants)->count(5)->create();
    }
}
