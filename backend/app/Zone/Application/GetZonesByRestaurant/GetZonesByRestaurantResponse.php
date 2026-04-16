<?php

namespace App\Zone\Application\GetZonesByRestaurant;

use App\Zone\Application\GetZoneByID\GetZoneByIDResponse;
use App\Zone\Domain\Entity\Zone;

final readonly class GetZonesByRestaurantResponse
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