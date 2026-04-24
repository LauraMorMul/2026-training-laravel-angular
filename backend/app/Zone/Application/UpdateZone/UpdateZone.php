<?php

namespace App\Zone\Application\UpdateZone;

use App\Shared\Domain\ValueObject\Name;
use App\Zone\Domain\Interfaces\ZoneRepositoryInterface;

class UpdateZone
{
    public function __construct(
        private ZoneRepositoryInterface $zoneRepository,
    ) {}

    public function __invoke(string $uuid, ?string $name, int $restaurantID): ?UpdateZoneResponse
    {
        $zone = $this->zoneRepository->findById($uuid);

        if ($zone === null || $zone->restaurantID()->value() !== $restaurantID) {
            return null;
        }

        if ($name === null) {
            $nameVO = $zone->name();
        } else {
            $nameVO = Name::create($name);
        }

        $zone = $zone->updateData($nameVO);
        $this->zoneRepository->save($zone);

        return UpdateZoneResponse::create($zone);
    }
}
