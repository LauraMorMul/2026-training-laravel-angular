<?php

namespace App\Product\Infrastructure\Entrypoint\Http;

use App\Product\Application\UpdateProduct\UpdateProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatchProductController
{
    public function __construct(
        private UpdateProduct $updateProduct
    ) {}

    public function __invoke(string $id, Request $request): JsonResponse
    {
        $restaurantId = auth('user')->user()->restaurant_id;
        $validated = $request->validate([
            'family_id' => ['string'],
            'tax_id' => ['string'],
            'image_src' => ['string', 'max:255'],
            'name' => ['string', 'max:255'],
            'price' => ['integer'],
            'stock' => ['integer'],
            'active' => ['boolean'],
        ]);

        $response = ($this->updateProduct)(
            $id,
            $validated['family_id'] ?? null,
            $validated['tax_id'] ?? null,
            $validated['image_src'] ?? null,
            $validated['name'] ?? null,
            $validated['price'] ?? null,
            $validated['stock'] ?? null,
            $validated['active'] ?? null,
            $restaurantId
        );

        return new JsonResponse($response->toArray(), 200);
    }
}
