<?php

namespace App\Family\Infrastructure\Entrypoint\Http;

use App\Family\Application\DeleteFamilyByID\DeleteFamilyByID;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;

class DeleteFamilyByIDController
{
    public function __construct(
        private DeleteFamilyByID $deleteFamilyByID,
    ) {}

    public function __invoke(string $id): JsonResponse
    {
        try {
            $response = ($this->deleteFamilyByID)($id);
        } catch(InvalidArgumentException $e) {
            return new JsonResponse('Family not found.', 404);
        }
        return new JsonResponse('Family deleted correctly.', 200);
    }
}
