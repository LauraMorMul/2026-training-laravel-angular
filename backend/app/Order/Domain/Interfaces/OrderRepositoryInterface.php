<?php

namespace App\Order\Domain\Interfaces;

use App\Order\Domain\Entity\Order;

interface OrderRepositoryInterface
{
    public function save(Order $order);

    public function getByRestaurantId(string $restaurantId): array;

    public function findByTableUuidAndActive(string $tableUuid): ?Order;

    public function findIdByUuid(string $uuid, int $restaurantId): ?int;

    public function deleteById(string $id): void;
}
