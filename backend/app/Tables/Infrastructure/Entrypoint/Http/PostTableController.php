<?php

namespace App\Tables\Infrastructure\Entrypoint\Http;

use App\Tables\Application\CreateTable\CreateTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostTableController
{
    public function __construct(
        private CreateTable $createTable,
    ){}

    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'restaurant_id' => ['required', 'integer', 'exists:restaurants,id'],
            'zone_id' => ['required', 'integer', 'exists:zones,id'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $response = ($this->createTable)(
            $validated['restaurant_id'],
            $validated['zone_id'],
            $validated['name'],
        );

        return new JsonResponse($response->toArray(), 201);
    }
}