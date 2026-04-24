<?php

namespace App\Table\Application\GetTablesByRestaurant;

use App\Table\Domain\Entity\Table;
use App\Table\Domain\Interfaces\TableRepositoryInterface;
use App\Zone\Domain\Interfaces\ZoneRepositoryInterface;

class GetTablesByRestaurant
{
    public function __construct(
        private TableRepositoryInterface $tableRepository,
        private ZoneRepositoryInterface $zoneRepository,
    ) {}

    public function __invoke(int $restaurantID): ?GetTablesByRestaurantResponse
    {
        $tables = $this->tableRepository->getByRestaurant($restaurantID);
        if ($tables === null) {
            return null;
        }

        $tablesWithRelations = array_map(
            function (Table $table) {
                $zone = $this->zoneRepository->findByInternalID($table->zoneID()->value());

                return [
                    'table' => $table,
                    'zone' => $zone,
                ];
            },
            $tables
        );

        return GetTablesByRestaurantResponse::create($tablesWithRelations);
    }
}
