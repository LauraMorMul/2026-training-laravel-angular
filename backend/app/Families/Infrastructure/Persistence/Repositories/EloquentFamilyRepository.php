<?php

use App\Families\Infrastructure\Persistence\Models\EloquentFamily;
use App\Families\Domain\Entity\Family;
use App\Family\Domain\Interface\FamilyRepositoryInterface;

class EloquentFamilyRepository implements FamilyRepositoryInterface
{
    public function __construct(
        private EloquentFamily $model,
    ) {}

    public function save(Family $family): void
    {
        $this->model->newQuery()->updateOrCreate(
            ['uuid' => $family->id()->value()],
            [
                'restaurant_id' => $family->restaurantID(),
                'name' => $family->name(),
                'active' => $family->active(),
                'created_at' => $family->createdAt()->value(),
                'updated_at' => $family->updatedAt()->value(),
            ]
        );
    }

    public function findById(string $id): ?Family
    {
        $model = $this->model->newQuery()->where('uuid', $id)->first();

        if ($model === null) {
            return null;
        }

        return Family::fromPersistence(
            $model->uuid,
            $model->restaurant_id,
            $model->name,
            $model->active,
            $model->created_at->toDateTimeImmutable(),
            $model->updated_at->toDateTimeImmutable(),
        );
    }

    public function getAll(): ?array
    {
        $models = $this->model->newQuery()->getModels();
        $families = array();

        if ($models === null) {
            return null;
        }

        foreach($models as $model) {
            $family = Family::fromPersistence(
            $model->uuid,
            $model->restaurant_id,
            $model->name,
            $model->active,
            $model->created_at->toDateTimeImmutable(),
            $model->updated_at->toDateTimeImmutable(),
        );
            array_push($families, $family);
        }

        return $families;
    }

    public function getByRestaurant(string $restaurantID): ?array
    {
        $models = $this->model->newQuery()->where('restaurant_id', $restaurantID)->getModels();
        $families = array();

        if ($models === null) {
            return null;
        }

        foreach($models as $model) {
            $family = Family::fromPersistence(
            $model->uuid,
            $model->restaurant_id,
            $model->name,
            $model->active,
            $model->created_at->toDateTimeImmutable(),
            $model->updated_at->toDateTimeImmutable(),
        );
            array_push($families, $family);
        }

        return $families;
    }

    public function deleteByID(string $id): void
    {
        $this->model->newQuery()->where('uuid', $id)->delete();
    }
}