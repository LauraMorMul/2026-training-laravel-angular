<?php

namespace App\User\Infrastructure\Entrypoint\Http;

use App\User\Application\GetUsersByRestaurant\GetUsersByRestaurant;
use Illuminate\Http\JsonResponse;

class GetUserByRestaurantController
{
    public function __construct(
        private GetUsersByRestaurant $getUsersByRestaurant
    ){}

    public function __invoke(string $restaurantID)
    {
        $response = ($this->getUsersByRestaurant)($restaurantID);

        if($response == null) {
            return new JsonResponse('Users not found', 404);
        } else {
            return new JsonResponse($response->toArray(), 200);
        }        
    }
}