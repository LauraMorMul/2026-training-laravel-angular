<?php

namespace Database\Factories;

use App\Families\Infrastructure\Persistence\Models\EloquentFamily;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<EloquentFamily>
 */
class FamilyFactory extends Factory
{
    protected $model = EloquentFamily::class;

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
            'name' => fake()->randomElement(['carnes', 'pescados', 'vinos', 'postres', 'refrescos', 'frutas', 'verduras', 'postres', 'alcohol']),
            'active' => fake()->boolean(),
        ];
    }
}
