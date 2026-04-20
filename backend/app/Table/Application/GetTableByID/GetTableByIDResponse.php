<?php

namespace App\Table\Application\GetTableByID;

use App\Table\Domain\Entity\Table;

final readonly class GetTableByIDResponse
{
    public function __construct(
        public string $id,
        public int $restaurantID,
        public int $zoneID,
        public string $name,
        public string $createdAt,
        public string $updatedAt,
    ) {}

    public static function create(Table $table): self
    {
        return new self(
            id: $table->id()->value(),
            restaurantID: $table->restaurantID()->value(),
            zoneID: $table->zoneID()->value(),
            name: $table->name()->value(),
            createdAt: $table->createdAt()->format(\DateTimeInterface::ATOM),
            updatedAt: $table->updatedAt()->format(\DateTimeInterface::ATOM),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'restaurant_id' => $this->restaurantID,
            'zone_id' => $this->zoneID,
            'name' => $this->name,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
