<?php

namespace App\Zones\Application\DeleteZoneByID;

use App\Zones\Domain\Interfaces\ZoneRepositoryInterface;

class DeleteZoneByID
{
    public function __construct(
        private ZoneRepositoryInterface $zoneRepository,
    )
    {}

    public function __invoke(string $id): void
    {
        $deleted = $this->zoneRepository->deleteByID($id);
    }
}