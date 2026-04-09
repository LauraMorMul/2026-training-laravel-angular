<?php

namespace App\Taxes\Domain\Interfaces;

use App\Taxes\Domain\Entity\Tax;

interface TaxRepositoryInterface
{
    public function save(Tax $tax): void;

    public function findById(string $id): ?Tax;

    public function getAll(): ?array;

    public function getByRestaurant(string $restaurantID): ?array;

    public function deleteByID(string $id): void;
}