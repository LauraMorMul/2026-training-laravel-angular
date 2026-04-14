<?php

namespace App\Products\Application\DeleteProductByID;

use App\Products\Domain\Interfaces\ProductRepositoryInterface;

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