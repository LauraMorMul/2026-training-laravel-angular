<?php

namespace App\Product\Application\DeleteProductByID;

use App\Product\Domain\Interfaces\ProductRepositoryInterface;

class DeleteProductByID
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
    ) {}

    public function __invoke(string $id): void
    {
        $deleted = $this->productRepository->deleteByID($id);
    }
}