<?php

namespace App\Product\Application\GetProductsByRestaurant;

use App\Family\Domain\Interfaces\FamilyRepositoryInterface;
use App\Product\Domain\Entity\Product;
use App\Product\Domain\Interfaces\ProductRepositoryInterface;
use App\Tax\Domain\Interfaces\TaxRepositoryInterface;

class GetProductsByRestaurant
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private FamilyRepositoryInterface $familyRepository,
        private TaxRepositoryInterface $taxRepository,
    ) {}

    public function __invoke(string $restaurantID): ?GetProductsByRestaurantResponse
    {
        $products = $this->productRepository->getByRestaurant($restaurantID);

        if ($products === null) {
            return null;
        }

        $productsWithRelations = array_map(
            function (Product $product) {
                $family = $this->familyRepository->findByInternalID($product->familyID()->value());
                $tax = $this->taxRepository->findByInternalID($product->taxID()->value());

                return [
                    'product' => $product,
                    'family' => $family,
                    'tax' => $tax,
                ];
            },
            $products
        );

        return GetProductsByRestaurantResponse::create($productsWithRelations);
    }
}
