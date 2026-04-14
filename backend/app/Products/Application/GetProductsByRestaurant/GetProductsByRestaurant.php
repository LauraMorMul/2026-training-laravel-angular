<?php

namespace App\Products\Application\GetProductsByRestaurant;

use App\Products\Domain\Interfaces\ProductRepositoryInterface;

class GetProductsByRestaurant
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
    ){}

    public function __invoke(string $restaurantID): ?GetProductsByRestaurantResponse
    {
        $products = $this->productRepository->getByRestaurant($restaurantID);

        if($products == null) {
            return null;
        } else {
            return GetProductsByRestaurantResponse::create($products);
        }        
    }
}