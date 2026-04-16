<?php

namespace App\Table\Infrastructure\Entrypoint\Http;

use App\Table\Application\UpdateTable\UpdateTable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PatchTableController
{
    public function __construct(
        private UpdateTable $updateTable,
    ){}

    public function __invoke(string $id, Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['string', 'max:255'],
            'active' => ['boolean'],
        ]);

        $response = ($this->updateTable)(
            $id,
            $validated['name'] ?? null,
        );

        return new JsonResponse($response->toArray(), 200);
    }
}