<?php

namespace Database\Factories;

use App\Model;
use App\Orders\Infrastructure\Persistence\Models\EloquentOrder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Model>
 */
class  OrderFactory extends Factory
{
    protected $model = EloquentOrder::class;
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
            'status' =>fake()->randomElement(['open', 'cancelled', 'invoiced']),
            'table_id' => TableFactory::new(),
            'opened_by_user_id' => UserFactory::new(),
            'closed_by_user_id' => UserFactory::new(),
            'diners' => random_int(1, 50),
            'opened_at' => fake()->dateTimeBetween('-2 years', 'now', null),
            'closed_at' => fake()->dateTimeBetween('-2 years', 'now', null),
        ];
    }
}
