<?php

namespace App\Table\Application\UpdateTable;

use App\Shared\Domain\ValueObject\Name;
use App\Table\Domain\Interfaces\TableRepositoryInterface;
use App\Table\Domain\ValueObject\ZoneID;
use App\Zone\Domain\Interfaces\ZoneRepositoryInterface;

class UpdateTable
{
    public function __construct(
        private TableRepositoryInterface $tableRepository,
        private ZoneRepositoryInterface $zoneRepository,
    ) {}

    public function __invoke(string $uuid, ?string $zoneUUID, ?string $name, int $restaurantID): ?UpdateTableResponse
    {
        $table = $this->tableRepository->findById($uuid);

        if ($table === null || $table->restaurantID()->value() !== $restaurantID) {
            return null;
        }

        if ($zoneUUID === null) {
            $zoneIDVO = $table->zoneID();
        } else {
            $zoneID = $this->zoneRepository->findIDbyUUID($zoneUUID);
            $zoneIDVO = ZoneID::create($zoneID);
        }

        if ($name === null) {
            $nameVO = $table->name();
        } else {
            $nameVO = Name::create($name);
        }

        $table = $table->updateData($zoneIDVO, $nameVO);
        $this->tableRepository->save($table);

        return UpdateTableResponse::create($table);
    }
}
