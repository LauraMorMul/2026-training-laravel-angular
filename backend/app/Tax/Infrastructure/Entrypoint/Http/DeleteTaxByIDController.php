<?php

namespace App\Tax\Infrastructure\Entrypoint\Http;

use App\Tax\Application\DeleteTaxByID\DeleteTaxByID;
use Illuminate\Http\JsonResponse;

class DeleteTaxByIDController
{
    public function __construct(
        private DeleteTaxByID $deleteTaxByID,
    ) {}

    public function __invoke(string $id): JsonResponse
    {
        $restaurantId = auth('user')->user()->restaurant_id;
        $response = ($this->deleteTaxByID)($id, $restaurantId);
        if ($response == true) {
            return new JsonResponse('Tax deleted correctly.', 200);
        } else {
            return new JsonResponse("Tax doesn't exist.", 500);
        }
    }
}
