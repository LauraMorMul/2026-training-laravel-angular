<?php

namespace App\Tax\Infrastructure\Entrypoint\Http;

use App\Tax\Application\GetTaxesByRestaurant\GetTaxesByRestaurant;
use Illuminate\Http\JsonResponse;

class GetTaxesbyRestaurantController
{
    public function __construct(
        private GetTaxesByRestaurant $getTaxesByRestaurant
    ) {}

    public function __invoke()
    {
        $restaurantID = auth('user')->user()->restaurant_id;
        $response = ($this->getTaxesByRestaurant)($restaurantID);

        if ($restaurantID === null) {
            return new JsonResponse('Restaurant not found', 404);
        } elseif ($response == null) {
            return new JsonResponse('Taxes not found', 404);
        } else {
            return new JsonResponse($response->toArray(), 200);
        }
    }
}
