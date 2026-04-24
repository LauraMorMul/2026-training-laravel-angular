<?php

namespace App\Table\Infrastructure\Persistence\Repositories;

use App\Table\Domain\Entity\Table;
use App\Table\Domain\Interfaces\TableRepositoryInterface;
use App\Table\Infrastructure\Persistence\Models\EloquentTable;

class EloquentTableRepository implements TableRepositoryInterface
{
    public function __construct(
        private EloquentTable $model,
    ) {}

    public function save(Table $table): void
    {
        $this->model->newQuery()->updateOrCreate(
            ['uuid' => $table->id()->value()],
            [
                'restaurant_id' => $table->restaurantID()->value(),
                'zone_id' => $table->zoneID()->value(),
                'name' => $table->name()->value(),
                'created_at' => $table->createdAt()->value(),
                'updated_at' => $table->updatedAt()->value(),
            ]
        );
    }

    public function findById(string $id): ?Table
    {
        $model = $this->model->newQuery()->where('uuid', $id)->first();

        if ($model === null) {
            return null;
        }

        return Table::fromPersistence(
            $model->uuid,
            $model->restaurant_id,
            $model->zone_id,
            $model->name,
            $model->created_at->toDateTimeImmutable(),
            $model->updated_at->toDateTimeImmutable(),
        );
    }

    public function getByRestaurant(string $restaurantID): ?array
    {

        $models = $this->model->newQuery()->where('restaurant_id', $restaurantID)->get();
        $tables = [];

        if ($models === null) {
            return null;
        }

        foreach ($models as $model) {
            $table = Table::fromPersistence(
                $model->uuid,
                $model->restaurant_id,
                $model->zone_id,
                $model->name,
                $model->created_at->toDateTimeImmutable(),
                $model->updated_at->toDateTimeImmutable(),
            );
            array_push($tables, $table);
        }

        return $tables;
    }

    public function deleteByID(string $id): void
    {
        $tableModel = $this->model->newQuery()->where('uuid', $id)->first();

        if ($tableModel === null) {
            return;
        }

        $tableModel->delete();
    }
}
