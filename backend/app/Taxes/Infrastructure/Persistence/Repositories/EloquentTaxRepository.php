<?php

namespace App\Taxes\Infrastructure\Persistence\Repositories;

use App\Taxes\Domain\Entity\Tax;
use App\Taxes\Domain\Interfaces\TaxRepositoryInterface;
use App\Taxes\Infrastructure\Persistence\Models\EloquentTax;

class EloquentTaxRepository implements TaxRepositoryInterface
{
    public function __construct(
        private EloquentTax $model,
    ) {}

    public function sace(Tax $tax): void
    {
        $this->model->newQuery()->updateOrCreate(
            ['uuid' => $tax->id()->value()],
            [
                'restaurant_id' => $tax->restaurantID(),
                'name' => $tax->name()->value(),
                'percentage' => $tax->percentage(),
                'created_at' => $tax->createdAt()->value(),
                'updated_at' => $tax->updatedAt()->value(),
            ]
        );
    }

    public function findByID(string $id): ?Tax
    {
        $model = $this->model->newQuery()->where('uuid', $id)->first();

        if ($model === null) {
            return null;
        }

        return Tax::fromPersistence(
            $model->uuid,
            $model->restaurant_id,
            $model->name,
            $model->percentage,
            $model->created_at->toDateTimeImmutable(),
            $model->updated_at->toDateTimeImmutable(),
        );
    }






    
}