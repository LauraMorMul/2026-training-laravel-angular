<?php

namespace App\Family\Application\Response;

use App\Family\Domain\Entity\Family;

final readonly class FamilyItemResponse
{
    private function __construct(
        private string $id,
        private string $name,
        private bool $active,
    ) {}

    public static function create(Family $family): self
    {
        return new self(
            id: $family->id()->value(),
            name: $family->name()->value(),
            active: $family->active(),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'active' => $this->active,
        ];
    }
}
