<?php

namespace App\Family\Infrastructure\Entrypoint\Http;

use App\Family\Application\GetFamiliesByRestaurant\GetFamiliesByRestaurant;
use Illuminate\Http\JsonResponse;

class GetFamiliesByRestaurantController
{
    public function __construct(
        private GetFamiliesByRestaurant $getFamiliesByRestaurant
    ){}

    public function __invoke(string $restaurantID)
    {
        $response = ($this->getFamiliesByRestaurant)($restaurantID);

        if($response == null) {
            return new JsonResponse('Families not found', 404);
        } else {
            return new JsonResponse($response->toArray(), 200);
        }        
    }
}