<?php

namespace App\Table\Application\CreateTable;

use App\Table\Domain\Entity\Table;

final readonly class CreateTableResponse
{
    private function __construct(
        private string $id,
        private int $restaurantID,
        private int $zoneID,
        private string $name,
        private string $createdAt,
        private string $updatedAt,
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
            'name' => $this->name,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
