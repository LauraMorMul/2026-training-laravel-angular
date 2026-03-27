<?php

namespace Database\Seeders;

use App\User\Infrastructure\Persistence\Models\EloquentUser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Collection $restaurants): Collection
    {
        return
        EloquentUser::factory()
        ->recycle($restaurants)
        ->count(5)
        ->create();
    }
}
