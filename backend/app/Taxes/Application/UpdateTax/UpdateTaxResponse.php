<?php

namespace App\Taxes\Application\UpdateTax;

use App\Taxes\Domain\Entity\Tax;

class UpdateTaxResponse
{
    public function __construct(
        public string $id,
        public string $restaurantID,
        public string $name,
        public int $percentage,
        public string $createdAt,
        public string $updatedAt,
    )
    {}

    public static function create(Tax $tax): self
    {
        return new self(
            id: $tax->id()->value(),
            restaurantID: $tax->restaurantID(),
            name: $tax->name()->value(),
            percentage: $tax->percentage(),
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