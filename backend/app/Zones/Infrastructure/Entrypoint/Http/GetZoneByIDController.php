<?php

namespace App\Zones\Infrastructure\Entrypoint\Http;

use App\Zones\Application\GetZoneByID\GetZoneByID;
use Illuminate\Http\JsonResponse;

class GetZoneByIDController
{
    public function __construct(
        private GetZoneByID $getZoneByID,
    )
    {}

    public function __invoke(string $id)
    {
        $response = ($this->getZoneByID)($id);
        if($response == null) {
            return new JsonResponse('Zone not found', 404);
        } else {
            return new JsonResponse($response->toArray(), 200);
        }
    }
}