<?php

namespace App\Family\Infrastructure\Entrypoint\Http;

use App\Family\Application\Command\DeleteFamilyCommand;
use App\Family\Application\Handler\DeleteFamilyHandler;
use App\Family\Domain\Exceptions\FamilyHasProductsException;
use App\Shared\Domain\Exceptions\EntityNotFoundException;
use Exception;
use Illuminate\Http\JsonResponse;

class DeleteFamilyByIDController
{
    public function __construct(
        private DeleteFamilyHandler $deleteHandler,
    ) {}

    public function __invoke(string $id): JsonResponse
    {
        $restaurantId = auth('user')->user()->restaurant_id;

        try {
            $command = new DeleteFamilyCommand($id, $restaurantId);

            ($this->deleteHandler)($command);
        } catch (EntityNotFoundException) {
            return new JsonResponse("Family doesn't exist.", 500);
        } catch (FamilyHasProductsException) {
            return new JsonResponse("Can't delete a family that has products.", 403);
        } catch (Exception) {
            return new JsonResponse('Something went wrong.', 500);
        }

        return new JsonResponse('Family deleted correctly.', 200);
    }
}
