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
        $validated = $request->validate([
            'name' => ['string', 'max:255'],
            'active' => ['boolean'],
        ]);

        $response = ($this->updateFamily)(
            $id,
            $validated['name'] ?? null,
            $validated['active'] ?? null,
        );

        return new JsonResponse($response->toArray(), 200);
    }
}
