<?php

namespace App\Zone\Application\DeleteZoneByID;

use App\Zone\Domain\Interfaces\ZoneRepositoryInterface;

class DeleteZoneByID
{
    public function __construct(
        private ZoneRepositoryInterface $zoneRepository,
    ) {}

    public function __invoke(string $id, int $restaurantID): bool
    {
        $exists = $this->zoneRepository->findById($id);
        if ($exists === null || $exists->restaurantID()->value() !== $restaurantID) {
            return false;
        } else {
            $deleted = $this->zoneRepository->deleteByID($id);

            return true;
        }
    }
}
