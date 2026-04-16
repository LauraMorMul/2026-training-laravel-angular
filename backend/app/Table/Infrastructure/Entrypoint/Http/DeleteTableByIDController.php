<?php

namespace App\Table\Infrastructure\Entrypoint\Http;

use App\Table\Application\DeleteTableByID\DeleteTableByID;
use Illuminate\Http\JsonResponse;

class DeleteTableByIDController
{
    public function __construct(
        private DeleteTableByID $deleteTableByID,
    ){}

    public function __invoke(string $id): JsonResponse
    {
        $response = ($this->deleteTableByID)($id);
        if($response == null) {
            return new JsonResponse('Table deleted correctly.', 200);
        } else {
            return new JsonResponse($response, 204);
        }
    }
}