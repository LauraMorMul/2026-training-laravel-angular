<?php

namespace App\Family\Infrastructure\Entrypoint\Http;

use App\Family\Application\UpdateFamily\UpdateFamily;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatchFamilyController
{
    public function __construct(
        private UpdateFamily $updateFamily,
    ) {}

    public function __invoke(string $id, Request $request): JsonResponse
    {
        $restaurantId = auth('user')->user()->restaurant_id;
        $validated = $request->validate([
            'name' => ['string', 'max:255'],
            'active' => ['boolean'],
        ]);

        $response = ($this->updateFamily)(
            $id,
            $validated['name'] ?? null,
            $validated['active'] ?? null,
            $restaurantId
        );

        return new JsonResponse($response->toArray(), 200);
    }
}
