<?php

namespace App\Product\Infrastructure\Entrypoint\Http;

use App\Product\Application\CreateProduct\CreateProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostProductController
{
    public function __construct(
        private CreateProduct $createProduct,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'restaurant_id' => ['required', 'integer', 'exists:restaurants,id'],
            'family_id' => ['required', 'integer', 'exists:families,id'],
            'tax_id' => ['required', 'integer', 'exists:taxes,id'],
            'image_src' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer'],
            'stock' => ['required', 'integer'],
            'active' => ['required', 'boolean'],
        ]);

        $response = ($this->createProduct)(
            $validated['restaurant_id'],
            $validated['family_id'],
            $validated['tax_id'],
            $validated['image_src'],
            $validated['name'],
            $validated['price'],
            $validated['stock'],
            $validated['active'],
        );

        return new JsonResponse($response->toArray(), 201);
    }
}
