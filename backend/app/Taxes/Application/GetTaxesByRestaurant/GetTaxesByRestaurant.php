<?php

namespace App\Taxes\Application\GetTaxesByRestaurant;

use App\Taxes\Application\GetTaxesByRestaurant\GetTaxesByRestaurantResponse;
use App\Taxes\Domain\Interfaces\TaxRepositoryInterface;

class GetTaxesByRestaurant
{
    public function __construct(
        private TaxRepositoryInterface $taxesRepository,
    ){}

    public function __invoke(string $restaurantID): ?GetTaxesByRestaurantResponse
    {
        $taxes = $this->taxesRepository->getByRestaurant($restaurantID);

        if($taxes == null) {
            return null;
        } else {
            return GetTaxesByRestaurantResponse::create($taxes);
        }        
    }
}