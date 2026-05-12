<?php

namespace App\Tax\Infrastructure\Entrypoint\Http;

use App\Shared\Domain\Exceptions\EntityNotFoundException;
use App\Shared\Domain\Exceptions\WrongRestaurantException;
use App\Tax\Application\DeleteTaxByID\DeleteTaxByID;
use App\Tax\Domain\Exceptions\TaxHasRelatedProductsException;
use Exception;
use Illuminate\Http\JsonResponse;

class DeleteTaxByIDController
{
    public function __construct(
        private DeleteTaxByID $deleteTaxByID,
    ) {}

    public function __invoke(string $id): JsonResponse
    {
        $restaurantId = auth('user')->user()->restaurant_id;
        try {
            ($this->deleteTaxByID)($id, $restaurantId);
        } catch (EntityNotFoundException) {
            return new JsonResponse("Family doesn't exist.", 500);
        } catch (WrongRestaurantException) {
            return new JsonResponse('This is not your restaurant.', 401);
        } catch (TaxHasRelatedProductsException) {
            return new JsonResponse("Can't delete a tax that has related products.", 403);
        } catch (Exception) {
            return new JsonResponse('Something went wrong.', 500);
        }

        return new JsonResponse('Tax deleted correctly.', 200);
    }
}
