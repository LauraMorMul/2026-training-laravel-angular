<?php

namespace App\Family\Infrastructure\Entrypoint\Http;

use App\Family\Application\Command\CreateFamilyCommand;
use App\Family\Application\Handler\CreateFamilyHandler;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostFamilyController
{
    public function __construct(
        private CreateFamilyHandler $createHandler,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'active' => ['required', 'boolean'],
        ]);

        $restaurantId = auth('user')->user()->restaurant_id;

        try {
            $command = new CreateFamilyCommand(
                $validated['name'],
                $validated['active'],
                $restaurantId,
            );

            ($this->createHandler)($command);
        } catch (Exception $e) {
            return new JsonResponse($e->getMessage(), 500);
        }

        return new JsonResponse(null, 201);
    }
}
