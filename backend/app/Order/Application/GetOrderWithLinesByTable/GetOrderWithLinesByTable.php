<?php

namespace App\Order\Application\GetOrderWithLinesByTable;

use App\Order\Domain\Interfaces\OrderLineRepositoryInterface;
use App\Order\Domain\Interfaces\OrderRepositoryInterface;

class GetOrderWithLinesByTable
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private OrderLineRepositoryInterface $orderLineRepository,
    ) {}

    public function __invoke(string $tableUuid, int $restaurantId): ?GetOrderWithLinesByTableResponse
    {
        $order = $this->orderRepository->findByTableUuidAndActive($tableUuid);

        if ($order === null) {
            return null;
        }

        $orderLines = $this->orderLineRepository->getByOrder($order->id()->value(), $restaurantId);
        dd($order->id()->value());

        if ($orderLines !== []) {
            $order = $order->withOrderLines($orderLines);
        }

        return GetOrderWithLinesByTableResponse::create($order, $tableUuid);
    }
}
