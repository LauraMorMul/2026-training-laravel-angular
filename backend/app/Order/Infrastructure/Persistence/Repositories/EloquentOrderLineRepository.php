<?php

namespace App\Order\Infrastructure\Persistence\Repositories;

use App\Order\Domain\Entity\OrderLine;
use App\Order\Domain\Interfaces\OrderLineRepositoryInterface;
use App\Order_line\Infrastructure\Persistence\Models\EloquentOrderLine;
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
    public function getByOrder(string $orderUuid): array
    {
        $models = $this->model->newQuery()
            ->whereHas('order', fn ($query) => $query->where('uuid', $orderUuid))
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
    public function deleteById(string $id): void
    {
        $orderLineModel = $this->model->newQuery()->where('uuid', $id)->first();

        if ($orderLineModel === null) {
            return;
        }

        $orderLineModel->delete();
    }
}
