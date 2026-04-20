<?php

namespace App\Zone\Application\GetZoneByID;

use App\Zone\Domain\Interfaces\ZoneRepositoryInterface;

class GetZoneByID
{
    public function __construct(
        private ZoneRepositoryInterface $zoneRepository
    ) {}

    public function __invoke(string $id): ?GetZoneByIDResponse
    {
        $zone = $this->zoneRepository->findByID($id);

        if ($zone == null) {
            return null;
        } else {
            return GetZoneByIDResponse::create($zone);
        }
    }
}
