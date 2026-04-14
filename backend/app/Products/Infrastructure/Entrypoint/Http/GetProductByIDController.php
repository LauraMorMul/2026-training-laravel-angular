<?php

namespace App\Products\Infrastructure\Entrypoint\Http;

use App\Products\Application\GetProductByID\GetProductByID;
use Illuminate\Http\JsonResponse;

class GetProductByIDController
{
    public function __construct(
        private GetProductByID $getProductByID,
    )
    {}

    public function __invoke(string $id)
    {
        $response = ($this->getProductByID)($id);
        if($response == null) {
            return new JsonResponse('Product not found', 404);
        } else {
            return new JsonResponse($response->toArray(), 200);
        }
        
    }
}