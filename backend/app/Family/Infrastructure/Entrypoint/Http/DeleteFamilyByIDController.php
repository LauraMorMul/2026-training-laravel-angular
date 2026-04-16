<?php


namespace App\Family\Infrastructure\Entrypoint\Http;

use App\Family\Application\DeleteFamilyByID\DeleteFamilyByID;
use Illuminate\Http\JsonResponse;

class DeleteFamilyByIDController
{
    public function __construct(
        private DeleteFamilyByID $deleteFamilyByID,
    ){}

    public function __invoke(string $id): JsonResponse
    {
        $response = ($this->deleteFamilyByID)($id);
        if($response == null) {
            return new JsonResponse('Family deleted correctly.', 200);
        } else {
            return new JsonResponse($response, 204);
        }
    }
}