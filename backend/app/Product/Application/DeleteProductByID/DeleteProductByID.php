<?php

namespace App\Product\Application\DeleteProductByID;

use App\Product\Domain\Interfaces\ProductRepositoryInterface;

class DeleteProductByID
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
    ) {}

    public function __invoke(string $id, int $restaurantID): bool
    {
        $exists = $this->productRepository->findById($id);
        if ($exists === null || $exists->restaurantID()->value() !== $restaurantID) {
            return false;
        } else {
            $deleted = $this->productRepository->deleteByID($id);

            return true;
        }
    }
}
