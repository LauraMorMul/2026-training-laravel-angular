<?php

namespace App\Zone\Domain\Interfaces;

use App\Zone\Domain\Entity\Zone;

interface ZoneRepositoryInterface
{
    public function save(Zone $family): void;

    public function findById(string $id): ?Zone;

    public function getByRestaurant(string $restaurantID): ?array;

    public function deleteByID(string $id): void;
}