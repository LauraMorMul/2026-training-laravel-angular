<?php

namespace App\Restaurant\Infastructure\Persistence\Repositories;

use App\Restaurants\Domain\Entity\Restaurant;
use App\Restaurants\Domain\Interfaces\RestaurantRepositoryInterface;
use App\Restaurants\Infrastructure\Persistence\Models\EloquentRestaurant;

class EloquentRestaurantRepository implements RestaurantRepositoryInterface
{
    public function __construct(
        private EloquentRestaurant $model
    ){}

    public function findById(string $id): ?Restaurant
    {
        $model = $this->model->newQuery()->where('uuid', $id)->first();

        if($model === null) {
            return null;
        }

        return Restaurant::fromPersistence(
            
        )
    }
}