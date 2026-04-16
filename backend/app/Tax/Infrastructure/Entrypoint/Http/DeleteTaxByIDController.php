<?php

namespace App\Tax\Infrastructure\Entrypoint\Http;

use App\Tax\Application\DeleteTaxByID\DeleteTaxByID;
use Illuminate\Http\JsonResponse;

class DeleteTaxByIDController
{
    public function __construct(
        private DeleteTaxByID $deleteTaxByID,
    ){}

    public function __invoke(string $id): JsonResponse
    {
        $response = ($this->deleteTaxByID)($id);
        if($response == null) {
            return new JsonResponse('Tax deleted correctly.', 200);
        } else {
            return new JsonResponse($response, 204);
        }
    }
}