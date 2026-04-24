<?php

namespace App\Table\Application\GetTableByID;

use App\Table\Domain\Entity\Table;
use App\Zone\Domain\Entity\Zone;

final readonly class GetTableByIDResponse
{
    public function __construct(
        public string $tableId,
        public int $tableRestaurantID,
        public string $tableName,
        public string $tableCreatedAt,
        public string $tableUpdatedAt,
        public string $zoneId
    ) {}

    public static function create(Table $table, Zone $zone): self
    {
        return new self(
            tableId: $table->id()->value(),
            tableRestaurantID: $table->restaurantID()->value(),
            tableName: $table->name()->value(),
            tableCreatedAt: $table->createdAt()->format(\DateTimeInterface::ATOM),
            tableUpdatedAt: $table->updatedAt()->format(\DateTimeInterface::ATOM),
            zoneId: $zone->id()->value(),
        );
    }

    public function toArray(): array
    {
        return [
            'table' => [
                'id' => $this->tableId,
                'zone_id' => $this->zoneId,
                'name' => $this->tableName,
                'created_at' => $this->tableCreatedAt,
                'updated_at' => $this->tableUpdatedAt,
            ],
        ];
    }
}
