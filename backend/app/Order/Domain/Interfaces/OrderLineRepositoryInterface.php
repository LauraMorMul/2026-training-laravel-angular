<?php

namespace App\Order\Domain\Interfaces;

use App\Order\Domain\Entity\OrderLine;

interface OrderLineRepositoryInterface
{
    public function save(OrderLine $orderLine): void;

    public function getByOrder(string $orderUuid): array;

    public function deleteById(string $id): void;
}
