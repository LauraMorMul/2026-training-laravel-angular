<?php

namespace App\Tax\Infrastructure\Entrypoint\Http;

use App\Tax\Application\CreateTax\CreateTax;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostTaxControlelr
{
    public function __construct(
        private CreateTax $createTax,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $restaurantId = auth('user')->user()->restaurant_id;

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'percentage' => ['required', 'integer'],
        ]);

        $response = ($this->createTax)(
            $restaurantId,
            $validated['name'],
            $validated['percentage'],
        );

        return new JsonResponse($response->toArray(), 201);
    }
}
