<?php

namespace App\Zones\Application\UpdateZone;

use App\Shared\Domain\ValueObject\Name;
use App\Zones\Domain\Interfaces\ZoneRepositoryInterface;

class UpdateZone
{
    public function __construct(
        private ZoneRepositoryInterface $zoneRepository,
    )
    {}

    public function __invoke(string $uuid, ?string $name): ? UpdateZoneResponse
    {
        $zone = $this->zoneRepository->findById($uuid);

        if($name === null) {
            $nameVO = $zone->name();
        }else {
            $nameVO = Name::create($name);
        }

        $zone = $zone->updateData($nameVO);
        $this->zoneRepository->save($zone);

        return UpdateZoneResponse::create($zone);
    }
}