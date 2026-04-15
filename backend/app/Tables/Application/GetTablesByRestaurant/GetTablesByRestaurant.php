<?php

namespace App\Tables\Application\GetTablesByRestaurant;

use App\Tables\Domain\Interfaces\TableRepositoryInterface;

class GetTablesByRestaurant
{
    public function __construct(
        private TableRepositoryInterface $tablesRepository,
    ){}

    public function __invoke(string $restaurantID): ?GetTablesByRestaurantResponse
    {
        $tables = $this->tablesRepository->getByRestaurant($restaurantID);

        if($tables == null) {
            return null;
        } else {
            return GetTablesByRestaurantResponse::create($tables);
        }        
    }
}