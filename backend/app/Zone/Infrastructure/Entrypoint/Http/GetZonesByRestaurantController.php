<?php

namespace App\Zone\Infrastructure\Entrypoint\Http;

use App\Zone\Application\GetZonesByRestaurant\GetZonesByRestaurant;
use Illuminate\Http\JsonResponse;

class GetZonesByRestaurantController
{
    public function __construct(
        private GetZonesByRestaurant $getZonesByRestaurant
    ) {}

    public function __invoke()
    {
        $restaurantID = auth('user')->user()->restaurant_id;
        $response = ($this->getZonesByRestaurant)($restaurantID);

        if ($response == null) {
            return new JsonResponse('Zones not found', 404);
        } else {
            return new JsonResponse($response->toArray(), 200);
        }
    }
}
