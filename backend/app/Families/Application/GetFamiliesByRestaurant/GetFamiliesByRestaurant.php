<?php

namespace App\Families\Application\GetFamiliesByRestaurant;

use App\Families\Domain\Interfaces\FamilyRepositoryInterface;

class GetFamiliesByRestaurant
{
    public function __construct(
        private FamilyRepositoryInterface $familyRepository,
    ){}

    public function __invoke(string $restaurantID): ?GetFamiliesByRestaurantResponse
    {
        $families = $this->familyRepository->getByRestaurant($restaurantID);

        if($families == null) {
            return null;
        } else {
            return GetFamiliesByRestaurantResponse::create($families);
        }        
    }
}