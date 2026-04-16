<?php

namespace App\Tax\Infrastructure\Entrypoint\Http;

use App\Tax\Application\GetTaxByID\GetTaxByID;
use Illuminate\Http\JsonResponse;

class GetTaxByIDController
{
    public function __construct(
        private GetTaxByID $getTaxByID,
    )
    {}

    public function __invoke(string $id)
    {
        $response = ($this->getTaxByID)($id);
        if($response == null) {
            return new JsonResponse('Family not found', 404);
        } else {
            return new JsonResponse($response->toArray(), 200);
        }
        
    }
}