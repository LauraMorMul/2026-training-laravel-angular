<?php

namespace App\Taxes\Infrastructure\Entrypoint\Http;

use App\Taxes\Application\CreateTax\CreateTax;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostTaxControlelr
{
    public function __construct(
        private CreateTax $createTax,
    ){}

    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'restaurant_id' => ['required', 'integer', 'exists:restaurants,id'],
            'name' => ['required', 'string', 'max:255'],
            'percentage' => ['required', 'integer'],
        ]);

        $response = ($this->createTax)(
            $validated['restaurant_id'],
            $validated['name'],
            $validated['percentage'],
        );

        return new JsonResponse($response->toArray(), 201);
    }
}