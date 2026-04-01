<?php

namespace App\User\Application\GetUsersByRestaurant;

use App\User\Domain\Interfaces\UserRepositoryInterface;
use App\User\Application\GetUsersByRestaurant\GetUsersByRestaurantResponse;

class GetUsersByRestaurant
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ){}

    public function __invoke(string $restaurantID): GetUsersByRestaurantResponse
    {
        $users = $this->userRepository->getByRestaurant($restaurantID);

        return GetUsersByRestaurantResponse::create($users);
    }
}