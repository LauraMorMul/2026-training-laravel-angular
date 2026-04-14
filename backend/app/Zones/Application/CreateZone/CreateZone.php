<?php

namespace App\Zones\Application\CreateZone;

use App\Zones\Domain\Entity\Zone;
use App\Zones\Domain\Interfaces\ZoneRepositoryInterface;
use App\Shared\Domain\ValueObject\Name;
use App\Shared\Domain\ValueObject\RestaurantID;

class CreateZone
{
    public function __construct(
        private ZoneRepositoryInterface $zoneRepository
    )
    {}

    public function __invoke(int $restaurantID, string $name): CreateZoneResponse
    {
        $restaurantIDVO = RestaurantID::create($restaurantID);
        $nameVO = Name::create($name);
        $zone = Zone::dddCreate($restaurantIDVO, $nameVO);
        $this->zoneRepository->save($zone);

        return CreateZoneResponse::create($zone);
    }
}