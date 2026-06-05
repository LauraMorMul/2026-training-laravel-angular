<?php

namespace App\Sale\Infrastructure\Persistence\Repositories;

use App\Sale\Domain\Entity\Sale;
use App\Sale\Domain\Interfaces\SaleRepositoryInterface;
use App\Sale\Infrastructure\Persistence\Models\EloquentSale;

class EloquentSaleRepository implements SaleRepositoryInterface
{
    public function __construct(
        private EloquentSale $model,
    ) {}

    public function save(Sale $sale): void
    {
        $this->model->newQuery()->updateOrCreate(
            ['uuid' => $sale->id()->value()],
            [
                'restaurant_id' => $sale->restaurantID()->value(),
                'order_id' => $sale->orderId()->value(),
                'user_id' => $sale->userId()->value(),
                'ticket_number' => substr($sale->ticketNumber()->value(), 2),
                'value_date' => $sale->valueDate()->value(),
                'total' => $sale->total()->value(),
                'created_at' => $sale->createdAt()->value(),
                'updated_at' => $sale->updatedAt()->value(),
            ]
        );
    }

    public function getLastTicketNumber(int $restaurantId, int $year): int
    {
        return $this->model
            ->where('restaurant_id', $restaurantId)
            ->whereYear('created_at', $year)
            ->max('ticket_number') ?? 0;
    }

    public function findIdByUuid(string $uuid, int $restaurantId): ?int
    {
        $model = $this->model->newQuery()->where('uuid', $uuid)->value('id');

        if ($model === null) {
            return null;
        }

        return $model;
    }
}
