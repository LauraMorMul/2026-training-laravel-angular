<?php

namespace App\Zone\Application\CreateZone;

use App\Shared\Domain\ValueObject\Name;
use App\Shared\Domain\ValueObject\RestaurantID;
use App\Zone\Domain\Entity\Zone;
use App\Zone\Domain\Interfaces\ZoneRepositoryInterface;

class CreateZone
{
    public function __construct(
        private ZoneRepositoryInterface $zoneRepository
    ) {}

    public function __invoke(int $restaurantID, string $name): CreateZoneResponse
    {
        $restaurantIDVO = RestaurantID::create($restaurantID);
        $nameVO = Name::create($name);
        $zone = Zone::dddCreate($restaurantIDVO, $nameVO);
        $this->zoneRepository->save($zone);

        return CreateZoneResponse::create($zone);
    }
}
