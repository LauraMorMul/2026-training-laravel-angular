<?php

namespace App\Product\Application\CreateProduct;

use App\Product\Domain\Entity\Product;

final readonly class CreateProductResponse
{
    private function __construct(
        private string $id,
        private int $restaurantID,
        private int $familyID,
        private int $taxID,
        private string $imageSrc,
        private string $name,
        private int $price,
        private int $stock,
        private bool $active,
        private string $createdAt,
        private string $updatedAt,
    ) {}

    public static function create(Product $product): self
    {
        return new self(
            id: $product->id()->value(),
            restaurantID: $product->restaurantID()->value(),
            familyID: $product->familyID()->value(),
            taxID: $product->taxID()->value(),
            imageSrc: $product->imageSrc()->value(),
            name: $product->name()->value(),
            price: $product->price()->value(),
            stock: $product->stock()->value(),
            active: $product->active(),
            createdAt: $product->createdAt()->format(\DateTimeInterface::ATOM),
            updatedAt: $product->updatedAt()->format(\DateTimeInterface::ATOM),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'image_src' => $this->imageSrc,
            'name' => $this->name,
            'price' => $this->price,
            'stock' => $this->stock,
            'active' => $this->active,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
