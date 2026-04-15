<?php

namespace App\Tables\Infrastructure\Entrypoint\Http;

use App\Tables\Application\GetTablesByRestaurant\GetTablesByRestaurant;
use Illuminate\Http\JsonResponse;

class GetTablesByRestaurantController
{
    public function __construct(
        private GetTablesByRestaurant $getTablesByRestaurant
    )
    {}

    public function __invoke(string $restaurantID)
    {
        $response = ($this->getTablesByRestaurant)($restaurantID);

        if($response == null) {
            return new JsonResponse('Tables not found', 404);
        } else {
            return new JsonResponse($response->toArray(), 200);
        }        
    }
}