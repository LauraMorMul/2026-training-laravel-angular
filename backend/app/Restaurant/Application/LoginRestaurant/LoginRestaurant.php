<?php

namespace App\Restaurant\Application\LoginRestaurant;

use App\Restaurant\Domain\Interfaces\RestaurantRepositoryInterface;
use App\Restaurant\Domain\Interfaces\TokenManagerInterface;
use App\Shared\Domain\Interfaces\PasswordHasherInterface;
use Illuminate\Validation\ValidationException;

class LoginRestaurant
{
    public function __construct(
        private RestaurantRepositoryInterface $restaurantRepository,
        private PasswordHasherInterface $passwordHasher,
        private TokenManagerInterface $tokenManager
    ) {}

    public function __invoke(string $email, string $plainPassword)
    {
        $restaurant = $this->restaurantRepository->findByEmail($email);

        if ($restaurant === null || ! $this->passwordHasher->check($plainPassword, $restaurant->passwordHash()->value())) {
            throw ValidationException::withMessages([
                'Login' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $this->tokenManager->issueToken($restaurant);

        return LoginRestaurantResponse::create($restaurant, $token);
    }
}
