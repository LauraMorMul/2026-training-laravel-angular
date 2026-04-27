<?php

namespace App\Family\Infrastructure\Entrypoint\Http;

use App\Family\Application\DeleteFamilyByID\DeleteFamilyByID;
use Illuminate\Http\JsonResponse;

class DeleteFamilyByIDController
{
    public function __construct(
        private DeleteFamilyByID $deleteFamilyByID,
    ) {}

    public function __invoke(string $id): JsonResponse
    {
        $restaurantId = auth('user')->user()->restaurant_id;
        $response = ($this->deleteFamilyByID)($id, $restaurantId);
        if ($response == true) {
            return new JsonResponse('Family deleted correctly.', 200);
        } else {
            return new JsonResponse("Family doesn't exist.", 500);
        }
    }
}
