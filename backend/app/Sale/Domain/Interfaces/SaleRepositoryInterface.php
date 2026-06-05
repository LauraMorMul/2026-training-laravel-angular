<?php

namespace App\Sale\Domain\Interfaces;

use App\Sale\Domain\Entity\Sale;

interface SaleRepositoryInterface
{
    public function save(Sale $sale): void;

    public function getLastTicketNumber(int $restaurantId, int $year): int;

    public function findIdByUuid(string $uuid, int $restaurantId): ?int;
}
