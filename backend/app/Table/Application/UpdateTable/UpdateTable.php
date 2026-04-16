<?php

namespace App\Table\Application\UpdateTable;

use App\Shared\Domain\ValueObject\Name;
use App\Table\Domain\Interfaces\TableRepositoryInterface;
use App\Table\Domain\ValueObject\ZoneID;

class UpdateTable
{
    public function __construct(
        private TableRepositoryInterface $tableRepository,
    )
    {}

    public function __invoke(string $uuid, ?int $zoneID, ?string $name): ? UpdateTableResponse
    {
        $table = $this->tableRepository->findById($uuid);

        if($zoneID === null) {
            $zoneIDVO = $table->zoneID();
        } else {
            $zoneIDVO = ZoneID::create($zoneID);
        }

        if($name === null) {
            $nameVO = $table->name();
        }else {
            $nameVO = Name::create($name);
        }

        $table = $table->updateData($zoneIDVO, $nameVO);
        $this->tableRepository->save($table);

        return UpdateTableResponse::create($table);
    }
}