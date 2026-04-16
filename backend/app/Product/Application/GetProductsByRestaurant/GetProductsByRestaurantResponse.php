<?php

namespace App\Product\Application\GetProductsByRestaurant;

use App\Product\Application\GetProductByID\GetProductByIDResponse;
use App\Product\Domain\Entity\Product;

final readonly class GetProductsByRestaurantResponse
{
    public function __construct(
        private array $allProducts,
    ) {}

    public static function create(array $products):self {
        return new self(
            allProducts: array_map(
                fn(Product $product) => GetProductByIDResponse::create($product),
                $products
            )
        );
    }

    public function toArray(): array
    {
        return array_map(
            fn(GetProductByIDResponse $product) => $product->toArray(),
            $this->allProducts
        );
    }
}