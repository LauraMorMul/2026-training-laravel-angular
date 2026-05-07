<?php

namespace App\Tax\Application\UpdateTax;

use App\Tax\Domain\Entity\Tax;

final readonly class UpdateTaxResponse
{
    private function __construct(
        private string $id,
        private int $restaurantID,
        private string $name,
        private int $percentage,
        private string $createdAt,
        private string $updatedAt,
    ) {}

    public static function create(Tax $tax): self
    {
        return new self(
            id: $tax->id()->value(),
            restaurantID: $tax->restaurantID()->value(),
            name: $tax->name()->value(),
            percentage: $tax->percentage()->value(),
            createdAt: $tax->createdAt()->format(\DateTimeInterface::ATOM),
            updatedAt: $tax->updatedAt()->format(\DateTimeInterface::ATOM),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'restaurant_id' => $this->restaurantID,
            'name' => $this->name,
            'percentage' => $this->percentage,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
