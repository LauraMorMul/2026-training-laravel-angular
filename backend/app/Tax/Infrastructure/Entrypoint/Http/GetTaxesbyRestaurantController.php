<?php

namespace App\Tax\Infrastructure\Entrypoint\Http;

use App\Tax\Application\GetTaxesByRestaurant\GetTaxesByRestaurant;
use Illuminate\Http\JsonResponse;

class GetTaxesbyRestaurantController
{
    public function __construct(
        private GetTaxesByRestaurant $getTaxesByRestaurant
    ) {}

    public function __invoke(string $restaurantID)
    {
        $response = ($this->getTaxesByRestaurant)($restaurantID);

        if ($response == null) {
            return new JsonResponse('Families not found', 404);
        } else {
            return new JsonResponse($response->toArray(), 200);
        }
    }
}
