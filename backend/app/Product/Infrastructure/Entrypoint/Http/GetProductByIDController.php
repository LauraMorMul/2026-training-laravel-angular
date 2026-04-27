<?php

namespace App\Product\Infrastructure\Entrypoint\Http;

use App\Product\Application\GetProductByID\GetProductByID;
use Illuminate\Http\JsonResponse;

class GetProductByIDController
{
    public function __construct(
        private GetProductByID $getProductByID,
    ) {}

    public function __invoke(string $id)
    {
        $restaurantID = auth('user')->user()->restaurant_id;
        $response = ($this->getProductByID)($id, $restaurantID);
        if ($response == null) {
            return new JsonResponse('Product not found', 404);
        } else {
            return new JsonResponse($response->toArray(), 200);
        }

    }
}
