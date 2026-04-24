<?php

namespace App\Product\Application\GetProductByID;

use App\Family\Domain\Interfaces\FamilyRepositoryInterface;
use App\Product\Domain\Interfaces\ProductRepositoryInterface;
use App\Tax\Domain\Interfaces\TaxRepositoryInterface;

class GetProductByID
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private FamilyRepositoryInterface $familyRepository,
        private TaxRepositoryInterface $taxRepository
    ) {}

    public function __invoke(string $id): ?GetProductByIDResponse
    {
        $product = $this->productRepository->findByID($id);

        if ($product == null) {
            return null;
        } else {
            $family = $this->familyRepository->findByInternalID($product->familyID()->value());
            $tax = $this->taxRepository->findByInternalID($product->taxID()->value());

            return GetProductByIDResponse::create($product, $family, $tax);
        }
    }
}
