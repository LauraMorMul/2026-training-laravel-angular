<?php

namespace App\Table\Infrastructure\Entrypoint\Http;

use App\Table\Application\CreateTable\CreateTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;

class PostTableController
{
    public function __construct(
        private CreateTable $createTable,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $restaurantId = auth('user')->user()->restaurant_id;

        $validated = $request->validate([
            'zone_id' => ['required', 'string', 'exists:zones,uuid'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        try {
            $response = ($this->createTable)(
                $restaurantId,
                $validated['zone_id'],
                $validated['name'],
            );
        } catch (InvalidArgumentException $e) {
            return new JsonResponse('Invalid family ID or tax ID.', 400);
        }

        return new JsonResponse($response->toArray(), 201);
    }
}
