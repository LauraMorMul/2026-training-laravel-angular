<?php

namespace App\Family\Application\Response;

use App\Family\Domain\Entity\Family;

final readonly class GetFamilyByIdResponse
{
    private function __construct(
        private string $id,
        private string $name,
        private bool $active,
        private string $createdAt,
        private string $updatedAt,
    ) {}

    public static function create(Family $family): self
    {
        return new self(
            id: $family->id()->value(),
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
