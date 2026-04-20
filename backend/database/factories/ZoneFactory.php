<?php

namespace Database\Factories;

use App\Model;
use App\Zone\Infrastructure\Persistence\Models\EloquentZone;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Model>
 */
class ZoneFactory extends Factory
{
    protected $model = EloquentZone::class;

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
            'name' => fake()->randomElement(['terraza', 'sala', 'barra']),
        ];
    }
}
