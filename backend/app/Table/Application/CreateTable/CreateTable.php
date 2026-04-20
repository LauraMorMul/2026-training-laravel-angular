<?php

namespace App\Table\Application\CreateTable;

use App\Shared\Domain\ValueObject\Name;
use App\Shared\Domain\ValueObject\RestaurantID;
use App\Table\Domain\Entity\Table;
use App\Table\Domain\Interfaces\TableRepositoryInterface;
use App\Table\Domain\ValueObject\ZoneID;

class CreateTable
{
    public function __construct(
        private TableRepositoryInterface $tableRepository
    ) {}

    public function __invoke(int $restaurantID, int $zoneID, string $name): CreateTableResponse
    {
        $restaurantIDVO = RestaurantID::create($restaurantID);
        $nameVO = Name::create($name);
        $zoneIDVO = ZoneID::create($zoneID);
        $table = Table::dddCreate($restaurantIDVO, $zoneIDVO, $nameVO);
        $this->tableRepository->save($table);

        return CreateTableResponse::create($table);
    }
}
