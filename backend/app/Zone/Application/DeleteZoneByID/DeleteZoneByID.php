<?php

namespace App\Zone\Application\DeleteZoneByID;

use App\Zone\Domain\Interfaces\ZoneRepositoryInterface;

class DeleteZoneByID
{
    public function __construct(
        private ZoneRepositoryInterface $zoneRepository,
    ) {}

    public function __invoke(string $id): void
    {
        $deleted = $this->zoneRepository->deleteByID($id);
    }
}
