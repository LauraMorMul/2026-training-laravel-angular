<?php

namespace App\Product\Application\GetProductsByRestaurant;

use App\Product\Application\GetProductByID\GetProductByIDResponse;
use App\Product\Domain\Entity\Product;

final readonly class GetProductsByRestaurantResponse
{
    public function __construct(
        private array $allProducts,
    ) {}

    public static function create(array $productsWithRelations): self
    {
        return new self(
            allProducts: array_map(
                fn (array $data) => GetProductByIDResponse::create($data[0], $data[1], $data[2]),
                $productsWithRelations
            )
        );
    }

    public function toArray(): array
    {
        return array_map(
            fn (GetProductByIDResponse $product) => $product->toArray(),
            $this->allProducts
        );
    }
}
