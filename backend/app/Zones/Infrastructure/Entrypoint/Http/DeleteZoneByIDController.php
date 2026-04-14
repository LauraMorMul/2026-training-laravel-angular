<?php

namespace App\Zones\Infrastructure\Entrypoint\Http;

use App\Zones\Application\DeleteZoneByID\DeleteZoneByID;
use Illuminate\Http\JsonResponse;

class DeleteZoneByIDController
{
    public function __construct(
        private DeleteZoneByID $deleteZoneByID,
    ){}

    public function __invoke(string $id): JsonResponse
    {
        $response = ($this->deleteZoneByID)($id);
        if($response == null) {
            return new JsonResponse('Zone deleted correctly.', 200);
        } else {
            return new JsonResponse($response, 204);
        }
    }
}