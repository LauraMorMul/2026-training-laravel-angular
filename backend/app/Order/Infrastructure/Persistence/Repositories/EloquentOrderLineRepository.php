<?php

namespace App\Order\Infrastructure\Persistence\Repositories;

use App\Order\Domain\Entity\OrderLine;
use App\Order\Domain\Interfaces\OrderLineRepositoryInterface;
use App\Order\Infrastructure\Persistence\Models\EloquentOrderLine;
use Override;

class EloquentOrderLineRepository implements OrderLineRepositoryInterface
{
    public function __construct(
        private EloquentOrderLine $model,
    ) {}

    #[Override]
    public function save(OrderLine $orderLine): void
    {
        $this->model->newQuery()->updateOrCreate(
            ['uuid' => $orderLine->id()->value()],
            [
                'restaurant_id' => $orderLine->restaurantID()->value(),
                'order_id' => $orderLine->orderId()->value(),
                'product_id' => $orderLine->productId()->value(),
                'user_id' => $orderLine->userId()->value(),
                'quantity' => $orderLine->quantity()->value(),
                'price' => $orderLine->price()->value(),
                'tax_percentage' => $orderLine->taxPercentage()->value(),
                'created_at' => $orderLine->createdAt()->value(),
                'updated_at' => $orderLine->updatedAt()->value(),
            ]
        );
    }

    #[Override]
    public function getByOrder(string $orderUuid, int $restaurantId): array
    {
        $models = $this->model->newQuery()
            ->whereHas('order', fn ($query) => $query->where('uuid', $orderUuid))
            ->where('restaurant_id', $restaurantId)
            ->get();

        $orderLines = [];

        foreach ($models as $model) {
            $orderLine = OrderLine::fromPersistence(
                $model->uuid,
                $model->restaurant_id,
                $model->order_id,
                $model->product_id,
                $model->user_id,
                $model->quantity,
                $model->price,
                $model->tax_percentage,
                $model->created_at->toDateTimeImmutable(),
                $model->updated_at->toDateTimeImmutable(),
            );
            array_push($orderLines, $orderLine);
        }

        return $orderLines;
    }

    #[Override]
    public function findByOrderAndProduct(string $orderUuid, string $productUuid, int $restaurantId)
    {
        $model = $this->model
            ->where('restaurant_id', $restaurantId)
            ->whereIn('order_id', function ($query) use ($orderUuid) {
                $query->select('id')
                    ->from('orders')
                    ->where('uuid', $orderUuid)
                    ->whereNull('deleted_at');
            })
            ->whereIn('product_id', function ($query) use ($productUuid) {
                $query->select('id')
                    ->from('products')
                    ->where('uuid', $productUuid)
                    ->whereNull('deleted_at');
            })
            ->first();

        return $model;
    }

    #[Override]
    public function deleteById(string $id): void
    {
        $orderLineModel = $this->model->newQuery()->where('uuid', $id)->first();

        if ($orderLineModel === null) {
            return;
        }

        $orderLineModel->delete();
    }
}
