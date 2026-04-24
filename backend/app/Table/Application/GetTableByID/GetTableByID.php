<?php

namespace App\Table\Application\GetTableByID;

use App\Table\Domain\Interfaces\TableRepositoryInterface;
use App\Zone\Domain\Interfaces\ZoneRepositoryInterface;

class GetTableByID
{
    public function __construct(
        private TableRepositoryInterface $tableRepository,
        private ZoneRepositoryInterface $zoneRepository,
    ) {}

    public function __invoke(string $id, int $restaurantID): ?GetTableByIDResponse
    {
        $table = $this->tableRepository->findByID($id);

        if ($table == null || $table->restaurantID()->value() !== $restaurantID) {
            return null;
        } else {
            $zone = $this->zoneRepository->findByInternalID($table->zoneID()->value());

            return GetTableByIDResponse::create($table, $zone);
        }
    }
}
