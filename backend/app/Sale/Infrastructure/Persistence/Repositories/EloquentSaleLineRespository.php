<?php

namespace App\Sale\Infrastructure\Persistence\Repositories;

use App\Sale\Domain\Entity\SaleLine;
use App\Sale\Domain\Interfaces\SaleLineRepositoryInterface;
use App\Sale\Infrastructure\Persistence\Models\EloquentSaleLine;
use Override;

class EloquentSaleLineRespository implements SaleLineRepositoryInterface
{
    public function __construct(
        private EloquentSaleLine $model
    ) {}

    #[Override]
    public function save(SaleLine $saleLine): void
    {
        $this->model->newQuery()->updateOrCreate(
            ['uuid' => $saleLine->id()->value()],
            [
                'restaurant_id' => $saleLine->restaurantID()->value(),
                'sale_id' => $saleLine->saleId()->value(),
                'order_line_id' => $saleLine->orderLineId()->value(),
                'user_id' => $saleLine->userId()->value(),
                'quantity' => $saleLine->quantity()->value(),
                'price' => $saleLine->price()->value(),
                'tax_percentage' => $saleLine->taxPercentage()->value(),
                'created_at' => $saleLine->createdAt()->value(),
                'updated_at' => $saleLine->updatedAt()->value(),
            ]
        );
    }
}
