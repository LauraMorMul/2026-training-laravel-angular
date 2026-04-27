<?php

namespace App\Product\Infrastructure\Entrypoint\Http;

use App\Product\Application\DeleteProductByID\DeleteProductByID;
use Illuminate\Http\JsonResponse;

class DeleteProductByIDController
{
    public function __construct(
        private DeleteProductByID $deleteProductByID,
    ) {}

    public function __invoke(string $id): JsonResponse
    {
        $restaurantId = auth('user')->user()->restaurant_id;
        $response = ($this->deleteProductByID)($id, $restaurantId);
        if ($response == true) {
            return new JsonResponse('Product deleted correctly.', 200);
        } else {
            return new JsonResponse('Product not found.', 404);
        }
    }
}
