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
        $family = $this->zoneRepository->findById($uuid);

        if($name === null) {
            $nameVO = $family->name();
        }else {
            $nameVO = Name::create($name);
        }

        $family = $family->updateData($nameVO);
        $this->zoneRepository->save($family);

        return UpdateZoneResponse
::create($family);
    }
}