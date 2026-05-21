<?php

namespace App\User\Infrastructure\Entrypoint\Http;

use App\User\Application\GetUsersByRestaurant\GetUsersByRestaurant;
use Illuminate\Http\JsonResponse;

class GetUsersForBackofficeController
{
    public function __construct(
        private GetUsersByRestaurant $getUsersByRestaurant
    ) {}

    public function __invoke()
    {
        $restaurantID = auth('user')->user()->restaurant_id;
        $response = ($this->getUsersByRestaurant)($restaurantID);

        if ($restaurantID == null) {
            return new JsonResponse('No restaurant', 404);
        } elseif ($response == null) {
            return new JsonResponse('Users not found backoffice'.$restaurantID, 404);
        } else {
            return new JsonResponse($response->toArray(), 200);
        }
    }
}
