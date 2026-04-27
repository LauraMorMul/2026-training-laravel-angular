<?php

namespace App\Tax\Infrastructure\Entrypoint\Http;

use App\Tax\Application\UpdateTax\UpdateTax;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatchTaxController
{
    public function __construct(
        private UpdateTax $updateTax
    ) {}

    public function __invoke(string $id, Request $request): JsonResponse
    {
        $restaurantId = auth('user')->user()->restaurant_id;
        $validated = $request->validate([
            'name' => ['string', 'max:255'],
            'percentage' => ['integer'],
        ]);

        $response = ($this->updateTax)(
            $id,
            $validated['name'] ?? null,
            $validated['percentage'] ?? null,
            $restaurantId
        );

        if ($response === null) {
            return new JsonResponse('Tax not found.', 404);
        } else {
            return new JsonResponse($response->toArray(), 200);
        }
    }
}
