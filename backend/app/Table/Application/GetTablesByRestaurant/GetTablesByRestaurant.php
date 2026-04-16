<?php

namespace App\Table\Application\GetTablesByRestaurant;

use App\Table\Domain\Interfaces\TableRepositoryInterface;

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