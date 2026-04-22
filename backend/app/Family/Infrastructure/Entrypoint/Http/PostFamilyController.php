<?php

namespace App\Family\Infrastructure\Entrypoint\Http;

use App\Family\Application\CreateFamily\CreateFamily;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostFamilyController
{
    public function __construct(
        private CreateFamily $createFamily,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'active' => ['required', 'boolean'],
        ]);

        $restaurantId = auth('user')->user()->restaurant_id;

        $response = ($this->createFamily)(
            $validated['name'],
            $validated['active'],
            $restaurantId,
        );

        return new JsonResponse($response->toArray(), 201);
    }
}
