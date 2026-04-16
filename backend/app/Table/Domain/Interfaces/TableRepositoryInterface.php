<?php

namespace App\Table\Domain\Interfaces;

use App\Table\Domain\Entity\Table;

interface TableRepositoryInterface
{
    public function save(Table $table): void;

    public function findById(string $id): ?Table;

    public function getByRestaurant(string $restaurantID): ?array;

    public function deleteByID(string $id): void;
}