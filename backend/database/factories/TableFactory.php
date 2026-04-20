<?php

namespace Database\Factories;

use App\Model;
use App\Table\Infrastructure\Persistence\Models\EloquentTable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Model>
 */
class TableFactory extends Factory
{
    protected $model = EloquentTable::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'restaurant_id' => RestaurantFactory::new(),
            'zone_id' => ZoneFactory::new(),
            'name' => fake()->word(),
        ];
    }
}
