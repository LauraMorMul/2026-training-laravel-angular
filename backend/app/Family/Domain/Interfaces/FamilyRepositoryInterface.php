<?php

namespace App\Family\Domain\Interfaces;

use App\Family\Domain\Entity\Family;

interface FamilyRepositoryInterface
{
    public function save(Family $family): void;

    public function findById(string $id): ?Family;

    public function getAll(): ?array;

    public function getByRestaurant(string $restaurantID): ?array;

    public function deleteByID(string $id): void;
}