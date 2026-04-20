<?php

namespace App\Product\Application\GetProductByID;

use App\Product\Domain\Interfaces\ProductRepositoryInterface;

class GetProductByID
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {}

    public function __invoke(string $id): ?GetProductByIDResponse
    {
        $product = $this->productRepository->findByID($id);

        if ($product == null) {
            return null;
        } else {
            return GetProductByIDResponse::create($product);
        }
    }
}
