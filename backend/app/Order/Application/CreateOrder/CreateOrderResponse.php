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

    public static function create(Order $order, string $tableUuid)
    {
        return new self(
            id: $order->id()->value(),
            tableId: $tableUuid,
            diners: $order->diners()->value()
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'table_id' => $this->tableId,
            'diners' => $this->diners,
        ];
    }
}
