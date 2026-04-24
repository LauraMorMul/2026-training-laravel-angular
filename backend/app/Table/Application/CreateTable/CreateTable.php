<?php

namespace App\Table\Application\CreateTable;

use App\Shared\Domain\ValueObject\Name;
use App\Shared\Domain\ValueObject\RestaurantID;
use App\Table\Domain\Entity\Table;
use App\Table\Domain\Interfaces\TableRepositoryInterface;
use App\Table\Domain\ValueObject\ZoneID;
use App\Zone\Domain\Interfaces\ZoneRepositoryInterface;
use InvalidArgumentException;

class CreateTable
{
    public function __construct(
        private TableRepositoryInterface $tableRepository,
        private ZoneRepositoryInterface $zoneRepository,
    ) {}

    public function __invoke(int $restaurantID, string $zoneUUID, string $name): CreateTableResponse
    {
        $restaurantZone = $this->zoneRepository->findById($zoneUUID)->restaurantID()->value();

        if ($restaurantZone !== $restaurantID) {
            throw new InvalidArgumentException('Zone ID is incorrect.');
        } else {
            $zoneID = $this->zoneRepository->findIDbyUUID($zoneUUID);
        }

        $restaurantIDVO = RestaurantID::create($restaurantID);
        $nameVO = Name::create($name);
        $zoneIDVO = ZoneID::create($zoneID);
        $table = Table::dddCreate($restaurantIDVO, $zoneIDVO, $nameVO);
        $this->tableRepository->save($table);

        return CreateTableResponse::create($table);
    }
}
