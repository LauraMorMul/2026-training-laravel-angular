<?php

namespace App\Tax\Application\GetTaxesByRestaurant;

use App\Tax\Application\GetTaxesByRestaurant\GetTaxesByRestaurantResponse;
use App\Tax\Domain\Interfaces\TaxRepositoryInterface;

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