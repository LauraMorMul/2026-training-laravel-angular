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
        $validated = $request->validate([
            'zone_id' => ['integer'],
            'name' => ['string', 'max:255'],
        ]);

        $response = ($this->updateTable)(
            $id,
            $validated['zone_id'] ?? null,
            $validated['name'] ?? null,
        );

        return new JsonResponse($response->toArray(), 200);
    }
}
