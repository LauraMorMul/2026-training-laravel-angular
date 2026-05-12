<?php

namespace App\Family\Infrastructure\Entrypoint\Http;

use App\Family\Application\DeleteFamilyByID\DeleteFamilyByID;
use App\Family\Domain\Exceptions\FamilyHasProductsException;
use App\Shared\Domain\Exceptions\EntityNotFoundException;
use App\Shared\Domain\Exceptions\WrongRestaurantException;
use Exception;
use Illuminate\Http\JsonResponse;

class DeleteFamilyByIDController
{
    public function __construct(
        private DeleteFamilyByID $deleteFamilyByID,
    ) {}

    public function __invoke(string $id): JsonResponse
    {
        $restaurantId = auth('user')->user()->restaurant_id;
        try {
            ($this->deleteFamilyByID)($id, $restaurantId);
        } catch (EntityNotFoundException) {
            return new JsonResponse("Family doesn't exist.", 500);
        } catch (WrongRestaurantException) {
            return new JsonResponse('This is not your restaurant.', 401);
        } catch (FamilyHasProductsException) {
            return new JsonResponse("Can't delete a family that has products.", 403);
        } catch (Exception) {
            return new JsonResponse('Something went wrong.', 500);
        }

        return new JsonResponse('Family deleted correctly.', 200);
    }
}
