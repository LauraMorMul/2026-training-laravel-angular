<?php

namespace App\Zone\Infrastructure\Entrypoint\Http;

use App\Zone\Application\UpdateZone\UpdateZone;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatchZoneController
{
    public function __construct(
        private UpdateZone $updateZone,
    ) {}

    public function __invoke(string $id, Request $request): JsonResponse
    {
        $restaurantId = auth('user')->user()->restaurant_id;
        $validated = $request->validate([
            'name' => ['string', 'max:255'],
            'active' => ['boolean'],
        ]);

        $response = ($this->updateZone)(
            $id,
            $validated['name'] ?? null,
            $restaurantId
        );

        if ($response === null) {
            return new JsonResponse('Zone not found.', 404);
        } else {
            return new JsonResponse($response->toArray(), 200);
        }
    }
}
