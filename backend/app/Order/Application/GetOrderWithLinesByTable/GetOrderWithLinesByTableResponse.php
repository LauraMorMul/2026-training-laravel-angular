<?php

namespace App\Order\Application\GetOrderWithLinesByTable;

use App\Order\Domain\Entity\Order;
use App\Order\Domain\Entity\OrderLine;

final readonly class GetOrderWithLinesByTableResponse
{
    private function __construct(
        private string $id,
        private int $restaurantId,
        private string $status,
        private string $tableId,
        private int $openedByUserId,
        private ?int $closedByUserId,
        private int $diners,
        private string $openedAt,
        private ?string $closedAt,
        private string $createdAt,
        private string $updatedAt,
        private ?array $orderLines,
    ) {}

    public static function create(Order $order, string $tableUuid): self
    {
        return new self(
            id: $order->id()->value(),
            restaurantId: $order->restaurantID()->value(),
            status: $order->status()->value(),
            tableId: $tableUuid,
            openedByUserId: $order->openedByUserId()->value(),
            closedByUserId: $order->closedByUserId()?->value(),
            diners: $order->diners()->value(),
            openedAt: $order->openedAt()->format(\DateTimeInterface::ATOM),
            closedAt: $order->closedAt()?->format(\DateTimeInterface::ATOM),
            createdAt: $order->createdAt()->format(\DateTimeInterface::ATOM),
            updatedAt: $order->updatedAt()->format(\DateTimeInterface::ATOM),
            orderLines: $order->orderLines() === null
                ? null
                : array_map(
                    static fn (OrderLine $orderLine): array => [
                        'id' => $orderLine->id()->value(),
                        'restaurant_id' => $orderLine->restaurantID()->value(),
                        'order_id' => $order->id()->value(),
                        'product_id' => $orderLine->productId()->value(),
                        'user_id' => $orderLine->userId()->value(),
                        'quantity' => $orderLine->quantity()->value(),
                        'price' => $orderLine->price()->value(),
                        'tax_percentage' => $orderLine->taxPercentage()->value(),
                        'created_at' => $orderLine->createdAt()->format(\DateTimeInterface::ATOM),
                        'updated_at' => $orderLine->updatedAt()->format(\DateTimeInterface::ATOM),
                    ],
                    $order->orderLines()
                ),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'restaurant_id' => $this->restaurantId,
            'status' => $this->status,
            'table_id' => $this->tableId,
            'opened_by_user_id' => $this->openedByUserId,
            'closed_by_user_id' => $this->closedByUserId,
            'diners' => $this->diners,
            'opened_at' => $this->openedAt,
            'closed_at' => $this->closedAt,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'order_lines' => $this->orderLines,
        ];
    }
}
