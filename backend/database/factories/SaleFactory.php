<?php

namespace Database\Factories;

use App\Model;
use App\Orders\Infrastructure\Persistence\Models\EloquentOrder;
use App\Restaurants\Infrastructure\Persistence\Models\EloquentRestaurant;
use App\Sales\Infrastructure\Persistence\Models\EloquentSale;
use App\User\Infrastructure\Persistence\Models\EloquentUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Model>
 */
class SaleFactory extends Factory
{
    protected $model = EloquentSale::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'restaurant_id' => EloquentRestaurant::factory(),
            'order_id' => EloquentOrder::factory(),
            'user_id' => EloquentUser::factory(),
            'ticket_number' => random_int(1, 9999),
            'value_date' => fake()->dateTimeBetween('-2 years', 'now', null),
            'total' => random_int(1, 9999),
        ];
    }
}
