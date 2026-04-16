<?php

namespace App\Product\Domain\Interfaces;

use App\Product\Domain\Entity\Product;

interface ProductRepositoryInterface
{
    public function save(Product $product): void;

    public function findById(string $id): ?Product;

    public function getByRestaurant(string $restaurantID): ?array;

    public function deleteByID(string $id): void;
}