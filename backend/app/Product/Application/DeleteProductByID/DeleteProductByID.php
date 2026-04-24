<?php

namespace App\Product\Application\DeleteProductByID;

use App\Product\Domain\Interfaces\ProductRepositoryInterface;
use InvalidArgumentException;

class DeleteProductByID
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
    ) {}

    public function __invoke(string $id): void
    {
        $exists = $this->productRepository->findById($id);
        if ($exists === null) {
            throw new InvalidArgumentException("Family doesn't exist or is already deleted.");
        } else {
            $deleted = $this->productRepository->deleteByID($id);
        }

    }
}
