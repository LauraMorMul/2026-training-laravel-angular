<?php

namespace App\Products\Application\GetProductsByRestaurant;

use App\Products\Application\GetProductByID\GetProductByIDResponse;
use App\Products\Domain\Entity\Product;

class GetProductsByRestaurantResponse
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