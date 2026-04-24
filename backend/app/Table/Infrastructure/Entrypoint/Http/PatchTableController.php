<?php

namespace App\Table\Infrastructure\Entrypoint\Http;

use App\Table\Application\UpdateTable\UpdateTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatchTableController
{
    public function __construct(
        private UpdateTable $updateTable,
    ) {}

    public function __invoke(string $id, Request $request): JsonResponse
    {
        $restaurantId = auth('user')->user()->restaurant_id;

        $validated = $request->validate([
            'zone_id' => ['string'],
            'name' => ['string', 'max:255'],
        ]);

        $response = ($this->updateTable)(
            $id,
            $validated['zone_id'] ?? null,
            $validated['name'] ?? null,
            $restaurantId,
        );

        return new JsonResponse($response->toArray(), 200);
    }
}
