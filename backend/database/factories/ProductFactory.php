<?php

namespace Database\Factories;

use App\Product\Infrastructure\Persistence\Models\EloquentProduct;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Model>
 */
class ProductFactory extends Factory
{
    protected $model = EloquentProduct::class;
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
            'family_id' => FamilyFactory::new(),
            'tax_id' => TaxFactory::new(),
            'image_src' => fake()->imageUrl(),
            'name' => fake()->word(),
            'price' => random_int(0, 100),
            'stock' => random_int(0, 9999),
            'active' => fake()->boolean(),
        ];
    }
}
