<?php

namespace App\Family\Application\GetFamiliesByRestaurant;

use App\Family\Domain\Interfaces\FamilyRepositoryInterface;

class GetFamiliesByRestaurant
{
    public function __construct(
        private FamilyRepositoryInterface $familyRepository,
    ) {}

    public function __invoke(int $restaurantID): ?GetFamiliesByRestaurantResponse
    {
        $families = $this->familyRepository->getByRestaurant($restaurantID);

        if ($families == null) {
            return null;
        } else {
            return GetFamiliesByRestaurantResponse::create($families);
        }
    }
}
