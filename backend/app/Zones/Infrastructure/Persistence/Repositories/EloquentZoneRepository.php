<?php

namespace App\Zones\Infrastructure\Persistence\Repositories;

use App\Zones\Domain\Entity\Zone;
use App\Zones\Domain\Interfaces\ZoneRepositoryInterface;
use App\Zones\Infrastructure\Persistence\Models\EloquentZone;

class EloquentZoneRepository implements ZoneRepositoryInterface
{
    public function __construct(
        private EloquentZone $model,
    ) {}

    public function save(Zone $zone): void
    {
        $this->model->newQuery()->updateOrCreate(
            ['uuid' => $zone->id()->value()],
            [
                'restaurant_id' => $zone->restaurantID()->value(),
                'name' => $zone->name()->value(),
                'created_at' => $zone->createdAt()->value(),
                'updated_at' => $zone->updatedAt()->value(),
            ]
        );
    }

    public function findById(string $id): ?Zone
    {
        $model = $this->model->newQuery()->where('uuid', $id)->first();

        if ($model === null) {
            return null;
        }

        return Zone::fromPersistence(
            $model->uuid,
            $model->restaurant_id,
            $model->name,
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
        $zones = array();

        if ($models === null) {
            return null;
        }

        foreach($models as $model) {
            $zone = Zone::fromPersistence(
            $model->uuid,
            $model->restaurant_id,
            $model->name,
            $model->active,
            $model->created_at->toDateTimeImmutable(),
            $model->updated_at->toDateTimeImmutable(),
        );
            array_push($zones, $zone);
        }

        return $zones;
    }

    public function deleteByID(string $id): void
    {
        $this->model->newQuery()->where('uuid', $id)->delete();
    }
}