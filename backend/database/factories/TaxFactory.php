<?php

namespace Database\Factories;

use App\Taxes\Infrastructure\Persistence\Models\EloquentTax;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Model>
 */
class TaxFactory extends Factory
{
    protected $model = EloquentTax::class;
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
            'name' => fake()->word(),
            'percentage' => fake()->randomDigitNotNull(),
        ];
    }
}
