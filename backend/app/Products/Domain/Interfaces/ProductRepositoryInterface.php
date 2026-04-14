<?php

namespace App\Products\Domain\Interfaces;

use App\Products\Domain\Entity\Product;

interface ProductRepositoryInterface
{
    public function save(Product $product): void;

    public function findById(string $id): ?Product;

    public function getByRestaurant(string $restaurantID): ?array;

    public function deleteByID(string $id): void;
}