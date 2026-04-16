<?php

namespace App\Zone\Application\GetZonesByRestaurant;

use App\Zone\Domain\Interfaces\ZoneRepositoryInterface;

class GetZonesByRestaurant
{
    public function __construct(
        private ZoneRepositoryInterface $zonesRepository,
    ){}

    public function __invoke(string $restaurantID): ?GetZonesByRestaurantResponse
    {
        $zones = $this->zonesRepository->getByRestaurant($restaurantID);

        if($zones == null) {
            return null;
        } else {
            return GetZonesByRestaurantResponse::create($zones);
        }        
    }
}