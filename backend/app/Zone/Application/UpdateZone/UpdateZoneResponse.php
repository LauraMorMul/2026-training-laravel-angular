<?php

namespace App\Zone\Application\UpdateZone;

use App\Zone\Domain\Entity\Zone;

final readonly class UpdateZoneResponse
{
    private function __construct(
        private string $id,
        private int $restaurantID,
        private string $name,
        private string $createdAt,
        private string $updatedAt,
    ) {}

    public static function create(Zone $zone): self
    {
        return new self(
            id: $zone->id()->value(),
            restaurantID: $zone->restaurantID()->value(),
            name: $zone->name()->value(),
            createdAt: $zone->createdAt()->format(\DateTimeInterface::ATOM),
            updatedAt: $zone->updatedAt()->format(\DateTimeInterface::ATOM),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'restaurant_id' => $this->restaurantID,
            'name' => $this->name,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
