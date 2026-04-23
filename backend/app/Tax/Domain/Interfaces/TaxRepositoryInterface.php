<?php

namespace App\Tax\Domain\Interfaces;

use App\Tax\Domain\Entity\Tax;

interface TaxRepositoryInterface
{
    public function save(Tax $tax): void;

    public function findById(string $id): ?Tax;

    public function findByInternalID(int $id): ?Tax;

    public function findIDbyUUID(string $uuid): ?int;

    public function getByRestaurant(string $restaurantID): ?array;

    public function deleteByID(string $id): void;
}
