<?php

namespace App\Zone\Infrastructure\Entrypoint\Http;

use App\Zone\Application\DeleteZoneByID\DeleteZoneByID;
use Illuminate\Http\JsonResponse;

class DeleteZoneByIDController
{
    public function __construct(
        private DeleteZoneByID $deleteZoneByID,
    ) {}

    public function __invoke(string $id): JsonResponse
    {
        $restaurantId = auth('user')->user()->restaurant_id;
        $response = ($this->deleteZoneByID)($id, $restaurantId);
        if ($response == true) {
            return new JsonResponse('Zone deleted correctly.', 200);
        } else {
            return new JsonResponse("Zone doesn't exist.", 500);
        }
    }
}
