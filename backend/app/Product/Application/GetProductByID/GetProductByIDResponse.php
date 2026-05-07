<?php

namespace App\Product\Application\GetProductByID;

use App\Family\Domain\Entity\Family;
use App\Product\Domain\Entity\Product;
use App\Tax\Domain\Entity\Tax;

final readonly class GetProductByIDResponse
{
    private function __construct(
        private string $id,
        private string $restaurantID,
        private string $familyID,
        private string $imageSrc,
        private string $name,
        private int $price,
        private int $stock,
        private bool $active,
        private string $taxName,
        private int $taxPercentage,
        private string $taxUuid,
        private string $createdAt,
        private string $updatedAt,
    ) {}

    public static function create(Product $product, Family $family, Tax $tax): self
    {
        return new self(
            id: $product->id()->value(),
            restaurantID: $product->restaurantID()->value(),
            familyID: $family->id()->value(),
            imageSrc: $product->imageSrc()->value(),
            name: $product->name()->value(),
            price: $product->price()->value(),
            stock: $product->stock()->value(),
            active: $product->active(),
            taxName: $tax->name()->value(),
            taxPercentage: $tax->percentage()->value(),
            taxUuid: $tax->id()->value(),
            createdAt: $product->createdAt()->format(\DateTimeInterface::ATOM),
            updatedAt: $product->updatedAt()->format(\DateTimeInterface::ATOM),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'family_id' => $this->familyID,
            'image_src' => $this->imageSrc,
            'name' => $this->name,
            'price' => $this->price,
            'stock' => $this->stock,
            'active' => $this->active,
            'tax' => [
                'uuid' => $this->taxUuid,
                'name' => $this->taxName,
                'percentage' => $this->taxPercentage,
            ],
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
