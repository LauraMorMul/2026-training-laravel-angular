<?php

namespace Database\Factories;

use App\Model;
use App\Order_lines\Infrastructure\Persistence\Models\EloquentOrderLine;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Model>
 */
class OrderLineFactory extends Factory
{
    protected $model = EloquentOrderLine::class;
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
            'order_id' => OrderFactory::new(),
            'product_id' => ProductFactory::new(),
            'user_id' => UserFactory::new(),
            'quantity' => random_int(1, 25),
            'price' => random_int(1, 50000),
            'tax_percentage' => random_int(0, 100),
        ];
    }
}
