<?php

namespace App\Zone\Infrastructure\Entrypoint\Http;

use App\Zone\Application\UpdateZone\UpdateZone;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PatchZoneController
{
    public function __construct(
        private UpdateZone $updateZone,
    ){}

    public function __invoke(string $id, Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['string', 'max:255'],
            'active' => ['boolean'],
        ]);

        $response = ($this->updateZone)(
            $id,
            $validated['name'] ?? null,
        );

        return new JsonResponse($response->toArray(), 200);
    }
}