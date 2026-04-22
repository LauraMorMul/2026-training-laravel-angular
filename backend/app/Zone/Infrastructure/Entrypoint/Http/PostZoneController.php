<?php

namespace App\Zone\Infrastructure\Entrypoint\Http;

use App\Zone\Application\CreateZone\CreateZone;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostZoneController
{
    public function __construct(
        private CreateZone $createZone,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $restaurantId = auth('user')->user()->restaurant_id;
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $response = ($this->createZone)(
            $restaurantId,
            $validated['name'],
        );

        return new JsonResponse($response->toArray(), 201);
    }
}
