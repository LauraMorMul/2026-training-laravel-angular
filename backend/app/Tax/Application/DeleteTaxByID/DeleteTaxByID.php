<?php

namespace App\Tax\Application\DeleteTaxByID;

use App\Product\Domain\Interfaces\ProductRepositoryInterface;
use App\Shared\Domain\Exceptions\EntityNotFoundException;
use App\Shared\Domain\Exceptions\WrongRestaurantException;
use App\Tax\Domain\Exceptions\TaxHasRelatedProductsException;
use App\Tax\Domain\Interfaces\TaxRepositoryInterface;

class DeleteTaxByID
{
    public function __construct(
        private TaxRepositoryInterface $taxRepository,
        private ProductRepositoryInterface $productRepository,
    ) {}

    public function __invoke(string $id, int $restaurantID)
    {
        $foundTax = $this->taxRepository->findById($id);
        if ($foundTax === null) {
            throw new EntityNotFoundException;
        } else {
            if ($foundTax->restaurantID()->value() !== $restaurantID) {
                throw new WrongRestaurantException;
            } else {
                $taxInternalID = $this->taxRepository->findIDbyUUID($id);
                $productsWithTax = $this->productRepository->getByTax($taxInternalID);
                if (count($productsWithTax) > 0) {
                    throw new TaxHasRelatedProductsException;
                } else {
                    $this->taxRepository->deleteByID($id);
                }
            }
        }
    }
}
