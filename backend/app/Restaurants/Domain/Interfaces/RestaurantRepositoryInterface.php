<?php

namespace App\Restaurants\Domain\Interfaces;

use App\Restaurants\Domain\Entity\Restaurant;

interface RestaurantRepositoryInterface
{
    public function save(Restaurant $family): void;

    public function findById(string $id): ?Restaurant;

    public function getAll(): ?array;

    public function deleteByID(string $id): void;
}