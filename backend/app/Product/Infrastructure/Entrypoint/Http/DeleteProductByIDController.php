<?php

namespace App\Product\Infrastructure\Entrypoint\Http;

use App\Product\Application\DeleteProductByID\DeleteProductByID;
use Illuminate\Http\JsonResponse;

class DeleteProductByIDController
{
    public function __construct(
        private DeleteProductByID $deleteProductByID,
    ){}

    public function __invoke(string $id): JsonResponse
    {
        $response = ($this->deleteProductByID)($id);
        if($response == null) {
            return new JsonResponse('Product deleted correctly.', 200);
        } else {
            return new JsonResponse($response, 204);
        }
    }
}