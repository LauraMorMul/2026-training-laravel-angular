<?php

namespace App\Family\Application\CreateFamily;

use App\Family\Domain\Entity\Family;

final readonly class CreateFamilyResponse
{
    private function __construct(
        private string $id,
        private int $restaurantID,
        private string $name,
        private bool $active,
        private string $createdAt,
        private string $updatedAt,
    ) {}

    public static function create(Family $family): self
    {
        return new self(
            id: $family->id()->value(),
            restaurantID: $family->restaurantID()->value(),
            name: $family->name()->value(),
            active: $family->active(),
            createdAt: $family->createdAt()->format(\DateTimeInterface::ATOM),
            updatedAt: $family->updatedAt()->format(\DateTimeInterface::ATOM),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'active' => $this->active,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
