<?php

namespace App\Order\Infrastructure\Persistence\Repositories;

use App\Order\Domain\Entity\Order;
use App\Order\Domain\Interfaces\OrderRepositoryInterface;
use App\Order\Infrastructure\Persistence\Models\EloquentOrder;

class EloquentOrderRepository implements OrderRepositoryInterface
{
    public function __construct(
        private EloquentOrder $model,
    ) {}

    public function save(Order $order): void
    {
        $this->model->newQuery()->updateOrCreate(
            ['uuid' => $order->id()->value()],
            [
                'restaurant_id' => $order->restaurantID()->value(),
                'status' => $order->status()->value(),
                'table_id' => $order->tableId()->value(),
                'opened_by_user_id' => $order->openedByUserId()->value(),
                'closed_by_user_id' => $order->closedByUserId()?->value(),
                'diners' => $order->diners()->value(),
                'opened_at' => $order->openedAt()->value(),
                'closed_at' => $order->closedAt()?->value(),
                'created_at' => $order->createdAt()->value(),
                'updated_at' => $order->updatedAt()->value(),
            ]
        );
    }

    public function findIdByUuid(string $uuid, int $restaurantId): ?int
    {
        $model = $this->model->newQuery()->where('uuid', $uuid)->value('id');

        if ($model === null) {
            return null;
        }

        return $model;
    }

    public function getByRestaurantId(string $restaurantId): array
    {
        $models = $this->model->newQuery()->where('restaurant_id', $restaurantId)->get();
        $orders = [];

        foreach ($models as $model) {
            $order = Order::fromPersistence(
                $model->uuid,
                $model->restaurant_id,
                $model->status,
                $model->table_id,
                $model->opened_by_user_id,
                $model->closed_by_user_id,
                $model->diners,
                $model->opened_at->toDateTimeImmutable(),
                $model->closed_at?->toDateTimeImmutable(),
                $model->created_at->toDateTimeImmutable(),
                $model->updated_at->toDateTimeImmutable(),
            );
            array_push($orders, $order);
        }

        return $orders;
    }

    public function findByTableUuidAndActive(string $tableUuid): ?Order
    {
        $model = $this->model->newQuery()
            ->whereIn('table_id', function ($query) use ($tableUuid) {
                $query->from('tables')
                    ->select('id')
                    ->where('uuid', $tableUuid);
            })
            ->where('status', 'open')
            ->first();

        if ($model === null) {
            return null;
        }

        return Order::fromPersistence(
            $model->uuid,
            $model->restaurant_id,
            $model->status,
            $model->table_id,
            $model->opened_by_user_id,
            $model->closed_by_user_id,
            $model->diners,
            $model->opened_at->toDateTimeImmutable(),
            $model->closed_at?->toDateTimeImmutable(),
            $model->created_at->toDateTimeImmutable(),
            $model->updated_at->toDateTimeImmutable(),
        );
    }

    public function deleteById(string $id): void
    {
        $orderModel = $this->model->newQuery()->where('uuid', $id)->first();

        if ($orderModel === null) {
            return;
        }

        $orderModel->delete();
    }
}
