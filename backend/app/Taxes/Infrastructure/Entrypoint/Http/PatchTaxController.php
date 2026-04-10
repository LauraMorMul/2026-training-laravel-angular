<?php

namespace App\Taxes\Infrastructure\Entrypoint\Http;

use App\Taxes\Application\UpdateTax\UpdateTax;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatchTaxController
{
    public function __construct(
        private UpdateTax $updateTax
    )
    {}

    public function __invoke(string $id, Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['string', 'max:255'],
            'percentage' => ['integer'],
        ]);

        $response = ($this->updateTax)(
            $id,
            $validated['name'] ?? null,
            $validated['percentage'] ?? null,
        );

        return new JsonResponse($response->toArray(), 200);
    }
}