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
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp,avif,svg'],
            'name' => ['string', 'max:255'],
            'price' => ['integer'],
            'stock' => ['integer'],
            'active' => ['boolean'],
        ]);

        $imageContent = null;
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageContent = file_get_contents($image->getRealPath());
            $imageName = $image->hashName();
        }

        $response = ($this->updateProduct)(
            $id,
            $imageContent,
            $imageName,
            $validated['family_id'] ?? null,
            $validated['tax_id'] ?? null,
            $validated['name'] ?? null,
            $validated['price'] ?? null,
            $validated['stock'] ?? null,
            $validated['active'] ?? null,
            $restaurantId
        );

        return new JsonResponse($response->toArray(), 200);
    }
}
