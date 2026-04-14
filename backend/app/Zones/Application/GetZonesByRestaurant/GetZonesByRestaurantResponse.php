<?php

namespace App\Zones\Application\GetZonesByRestaurant;

use App\Zones\Application\GetZoneByID\GetZoneByIDResponse;
use App\Zones\Domain\Entity\Zone;

class GetZonesByRestaurantResponse
{
    public function __construct(
        private array $allZones,
    ) {}

    public static function create(array $families):self {
        return new self(
            allZones: array_map(
                fn(Zone $zone) => GetZoneByIDResponse::create($zone),
                $families
            )
        );
    }

    public function toArray(): array
    {
        return array_map(
            fn(GetZoneByIDResponse $zone) => $zone->toArray(),
            $this->allZones
        );
    }
}