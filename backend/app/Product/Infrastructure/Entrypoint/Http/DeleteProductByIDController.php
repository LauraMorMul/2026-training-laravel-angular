<?php

namespace App\Product\Infrastructure\Entrypoint\Http;

use App\Product\Application\DeleteProductByID\DeleteProductByID;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;

class DeleteProductByIDController
{
    public function __construct(
        private DeleteProductByID $deleteProductByID,
    ) {}

    public function __invoke(string $id): JsonResponse
    {
        try {
            $response = ($this->deleteProductByID)($id);
        } catch (InvalidArgumentException $e) {
            return new JsonResponse('Product not found.', 404);
        }

        return new JsonResponse('Product deleted correctly.', 200);
    }
}
