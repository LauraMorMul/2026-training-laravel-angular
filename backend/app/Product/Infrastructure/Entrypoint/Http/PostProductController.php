<?php

namespace App\Product\Infrastructure\Entrypoint\Http;

use App\Product\Application\CreateProduct\CreateProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;

class PostProductController
{
    public function __construct(
        private CreateProduct $createProduct,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $restaurantId = auth('user')->user()->restaurant_id;

        $validated = $request->validate([
            'family_id' => ['required', 'string', 'exists:families,uuid'],
            'tax_id' => ['required', 'string', 'exists:taxes,uuid'],
            'image' => ['required', 'image', 'mimes:jpeg,jpg,png,gif,webp,avif,svg'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer'],
            'stock' => ['required', 'integer'],
            'active' => ['required', 'boolean'],
        ]);

        if ($restaurantId === null) {
            return new JsonResponse('Unknown user', 403);
        }

        $imageContent = null;
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageContent = file_get_contents($image->getRealPath());
            $imageName = $image->hashName();
        }

        try {
            $response = ($this->createProduct)(
                $imageContent,
                $imageName,
                $validated['family_id'],
                $validated['tax_id'],
                $validated['name'],
                $validated['price'],
                $validated['stock'],
                $validated['active'],
                $restaurantId
            );
        } catch (InvalidArgumentException $e) {
            return new JsonResponse('Invalid family ID or tax ID.', 400);
        }

        return new JsonResponse($response->toArray(), 201);
    }
}
