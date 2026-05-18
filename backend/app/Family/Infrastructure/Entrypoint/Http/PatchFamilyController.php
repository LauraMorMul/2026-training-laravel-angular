<?php

namespace App\Family\Infrastructure\Entrypoint\Http;

use App\Family\Application\Command\UpdateFamilyCommand;
use App\Family\Application\Handler\UpdateFamilyHandler;
use App\Shared\Domain\Exceptions\EntityNotFoundException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatchFamilyController
{
    public function __construct(
        private UpdateFamilyHandler $updateHandler,
    ) {}

    public function __invoke(string $id, Request $request): JsonResponse
    {
        $restaurantId = auth('user')->user()->restaurant_id;
        $validated = $request->validate([
            'name' => ['string', 'max:255'],
            'active' => ['boolean'],
        ]);

        try {
            $command = new UpdateFamilyCommand(
                $id,
                $validated['name'] ?? null,
                $validated['active'] ?? null,
                $restaurantId
            );

            ($this->updateHandler)($command);
        } catch (EntityNotFoundException) {
            return new JsonResponse('Family not found.', 404);
        } catch (Exception) {
            return new JsonResponse('Something went wrong.', 500);
        }

        return new JsonResponse('Family updated.', 200);
    }
}
