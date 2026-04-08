<?php

namespace App\Families\Infrastructure\Entrypoint\Http;

use App\Families\Application\CreateFamily\CreateFamily;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostFamilyController
{
    public function __construct(
        private CreateFamily $createFamily,
    ){}

    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'restaurant_id' => ['required', 'integer', 'exists:restaurants,id'],
            'name' => ['required', 'string', 'max:255'],
            'active' => ['required', 'boolean'],
        ]);

        $response = ($this->createFamily)(
            $validated['restaurant_id'],
            $validated['name'],
            $validated['active'],
        );

        return new JsonResponse($response->toArray(), 201);
    }
}