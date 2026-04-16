<?php

namespace Database\Factories;

use App\Model;
use App\Order_line\Infrastructure\Persistence\Models\EloquentOrderLine;
use App\Sale\Infrastructure\Persistence\Models\EloquentSale;
use App\Sales_line\Infrastructure\Persistence\Models\EloquentSaleLine;
use App\User\Infrastructure\Persistence\Models\EloquentUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Model>
 */
class SaleLineFactory extends Factory
{
    protected $model = EloquentSaleLine::class;
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
            'sale_id' => EloquentSale::factory(),
            'order_line_id' => EloquentOrderLine::factory(),
            'user_id' => EloquentUser::factory(),
            'quantity' => random_int(1, 9999),
            'price' => random_int(1, 999999),
            'tax_percentage' => random_int(1, 100),
        ];
    }
}
