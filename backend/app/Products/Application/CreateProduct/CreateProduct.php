<?php

namespace App\Products\Application\CreateProduct;

use App\Products\Domain\Interfaces\ProductRepositoryInterface;

class CreateProduct
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
    ){}

    public function __invoke(int $restaurantID, )
    {}
}