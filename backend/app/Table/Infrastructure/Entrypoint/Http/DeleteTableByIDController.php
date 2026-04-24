<?php

namespace App\Table\Infrastructure\Entrypoint\Http;

use App\Table\Application\DeleteTableByID\DeleteTableByID;
use Illuminate\Http\JsonResponse;

class DeleteTableByIDController
{
    public function __construct(
        private DeleteTableByID $deleteTableByID,
    ) {}

    public function __invoke(string $id): JsonResponse
    {
        $restaurantId = auth('user')->user()->restaurant_id;
        $response = ($this->deleteTableByID)($id, $restaurantId);
        if ($response == true) {
            return new JsonResponse('Table deleted correctly.', 200);
        } else {
            return new JsonResponse('Table not found.', 404);
        }
    }
}
