<?php

namespace Database\Factories;

use App\User\Infrastructure\Persistence\Models\EloquentUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<EloquentUser>
 */
class UserFactory extends Factory
{
    protected $model = EloquentUser::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = fake()->firstName;
        $lastName = fake()->lastName;
        $fullName = $firstName.' '.$lastName;
        $email = $firstName.'.'.$lastName.'@company.com';
        $extension = fake()->randomElement(['jpeg', 'jpg', 'png', 'gif', 'webp', 'avif', 'svg']);
        $imageSrc = $firstName.'_'.$lastName.'.'.$extension;

        return [
            'uuid' => (string) Str::uuid(),
            'restaurant_id' => RestaurantFactory::new(),
            'role' => fake()->randomElement(['admin', 'camarero', 'barra', 'jefe_sala']),
            'image_src' => $imageSrc,
            'name' => $fullName,
            'email' => $email,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'pin' => random_int(1000, 9999),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
