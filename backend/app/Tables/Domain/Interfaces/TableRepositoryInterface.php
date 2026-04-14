<?php

namespace App\Tables\Domain\Interfaces;

use App\Tables\Domain\Entity\Table;

interface TableRepositoryInterface
{
    public function save(Table $table): void;

    public function findById(string $id): ?Table;

    public function getByRestaurant(string $restaurantID): ?array;

    public function deleteByID(string $id): void;
}