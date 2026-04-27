<?php

namespace App\Family\Infrastructure\Entrypoint\Http;

use App\Family\Application\GetFamilyByID\GetFamilyByID;
use Illuminate\Http\JsonResponse;

class GetFamilyByIDController
{
    public function __construct(
        private GetFamilyByID $getFamilyByID,
    ) {}

    public function __invoke(string $id)
    {
        $restaurantId = auth('user')->user()->restaurant_id;
        $response = ($this->getFamilyByID)($id, $restaurantId);
        if ($response == null) {
            return new JsonResponse('Family not found', 404);
        } else {
            return new JsonResponse($response->toArray(), 200);
        }

    }
}
