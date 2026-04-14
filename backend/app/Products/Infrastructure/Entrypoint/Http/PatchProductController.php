<?php

namespace App\Products\Infrastructure\Entrypoint\Http;

use App\Products\Application\UpdateProduct\UpdateProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatchProductController
{
    public function __construct(
        private UpdateProduct $updateProduct
    ){}

    public function __invoke(string $id, Request $request): JsonResponse
    {
        $validated = $request->validate([
            'image_src' => ['string', 'max:255'],
            'name' => ['string', 'max:255'],
            'price' => ['integer'],
            'stock' => ['integer'],
            'active' => ['boolean'],
        ]);

        $response = ($this->updateProduct)(
            $id,
            $validated['image_src'] ?? null,
            $validated['name'] ?? null,
            $validated['price'] ?? null,
            $validated['stock'] ?? null,
            $validated['active'] ?? null,
        );

        return new JsonResponse($response->toArray(), 200);
    }
}