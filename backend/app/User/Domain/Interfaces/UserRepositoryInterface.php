<?php

namespace App\User\Domain\Interfaces;

use App\User\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function findById(string $id): ?User;

    public function findByEmailAndRestaurant(string $email, int $id): ?User;

    public function findByEmail(string $email): ?User;

    public function getByRestaurant(int $restaurantID): ?array;

    public function deleteByID(string $id): void;
}
