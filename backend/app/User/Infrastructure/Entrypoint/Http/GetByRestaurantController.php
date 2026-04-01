<?php

namespace App\User\Infrastructure\Entrypoint\Http;

use App\User\Application\GetUsersByRestaurant\GetUsersByRestaurant;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetByRestaurantController
{
    public function __construct(
        private GetUsersByRestaurant $getUsersByRestaurant
    ){}

    public function __invoke(string $restaurantID)
    {
        $response = ($this->getUsersByRestaurant)($restaurantID);

        return new JsonResponse($response->toArray(), 200);
    }
}