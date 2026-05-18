<?php

namespace App\Family\Domain\Interfaces;

use App\Family\Domain\Entity\Family;

interface FamilyRepositoryInterface
{
    public function save(Family $family): void;

    public function findById(string $id, int $restaurantId): ?Family;

    public function findByInternalID(int $id): ?Family;

    public function findIDbyUUID(string $uuid): ?int;

    public function getByRestaurant(int $restaurantId): ?array;

    public function deleteByID(string $id, int $restaurantId): void;

    public function findFamilyWithProductsByUuid(string $id, int $restaurantId): ?Family;
}
