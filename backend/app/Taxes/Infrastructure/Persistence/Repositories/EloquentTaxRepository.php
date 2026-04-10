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

    public function save(Tax $tax): void
    {
        $this->model->newQuery()->updateOrCreate(
            ['uuid' => $tax->id()->value()],
            [
                'restaurant_id' => $tax->restaurantID()->value(),
                'name' => $tax->name()->value(),
                'percentage' => $tax->percentage()->value(),
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

    public function getByRestaurant(string $restaurantID): ?array
    {
        $models = $this->model->newQuery()->whereIn('restaurant_id', function($query) use ($restaurantID) {
            $query->select('id')
            ->from('restaurants')
            ->where('uuid', $restaurantID);
        })->getModels();

        $taxes = array();

        if ($models === null) {
            return null;
        }

        foreach($models as $model) {
            $tax = Tax::fromPersistence(
            $model->uuid,
            $model->restaurant_id,
            $model->name,
            $model->percentage,
            $model->created_at->toDateTimeImmutable(),
            $model->updated_at->toDateTimeImmutable(),
        );
            array_push($taxes, $tax);
        }

        return $taxes;
    }

    public function deleteByID(string $id): void
    {
        $this->model->newQuery()->where('uuid', $id)->delete();
    }
}