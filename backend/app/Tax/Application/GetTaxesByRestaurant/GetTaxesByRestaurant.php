<?php

namespace App\Tax\Application\GetTaxesByRestaurant;

use App\Tax\Domain\Interfaces\TaxRepositoryInterface;

class GetTaxesByRestaurant
{
    public function __construct(
        private TaxRepositoryInterface $taxesRepository,
    ) {}

    public function __invoke(int $restaurantID): ?GetTaxesByRestaurantResponse
    {
        $taxes = $this->taxesRepository->getByRestaurant($restaurantID);

        if ($taxes == null) {
            return null;
        } else {
            return GetTaxesByRestaurantResponse::create($taxes);
        }
    }
}
