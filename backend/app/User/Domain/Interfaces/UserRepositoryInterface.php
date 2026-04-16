<?php

namespace App\User\Domain\Interfaces;

use App\User\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function findById(string $id): ?User;

    public function getByEmail(string $email): ?User;

    public function getAll(): ?array;

    public function getByRestaurant(string $restaurantID): ?array;

    public function deleteByID(string $id): void;
}
