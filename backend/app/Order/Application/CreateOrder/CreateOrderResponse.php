<?php

namespace App\Order\Application\CreateOrder;

use App\Order\Domain\Entity\Order;

final readonly class CreateOrderResponse
{
    private function __construct(
        private string $id,
        private string $tableId,
        private int $diners,
    ) {}

    public static function create(Order $order)
    {
        return new self(
            id: $order->id()->value(),
            tableId: $order->tableId()->value(),
            diners: $order->diners()->value()
        );
    }
}
