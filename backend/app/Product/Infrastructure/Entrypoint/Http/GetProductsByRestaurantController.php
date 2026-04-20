<?php

namespace App\Product\Infrastructure\Entrypoint\Http;

use App\Product\Application\GetProductsByRestaurant\GetProductsByRestaurant;
use Illuminate\Http\JsonResponse;

class GetProductsByRestaurantController
{
    public function __construct(
        private GetProductsByRestaurant $getProductsByRestaurant
    ) {}

    public function __invoke(string $restaurantID)
    {
        $response = ($this->getProductsByRestaurant)($restaurantID);

        if ($response == null) {
            return new JsonResponse('Families not found', 404);
        } else {
            return new JsonResponse($response->toArray(), 200);
        }
    }
}
