<?php

namespace App\Products\Application\GetProductByID;

use App\Products\Domain\Entity\Product;

class GetProductByIDResponse
{
    public function __construct(
        public string $id,
        public int $restaurantID,
        public int $familyID,
        public int $taxID,
        public string $imageSrc,
        public string $name,
        public int $price,
        public int $stock,
        public bool $active,
        public string $createdAt,
        public string $updatedAt,
    )
    {}

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
            'restaurant_id' => $this->restaurantID,
            'family_id' => $this->familyID,
            'tax_id' => $this->taxID,
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