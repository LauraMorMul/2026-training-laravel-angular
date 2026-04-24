<?php

namespace App\Table\Application\GetTablesByRestaurant;

use App\Table\Application\GetTableByID\GetTableByIDResponse;

final readonly class GetTablesByRestaurantResponse
{
    public function __construct(
        private array $allTables,
    ) {}

    public static function create(array $tablesWithRelations): self
    {
        return new self(
            allTables: array_map(
                fn (array $data) => GetTableByIDResponse::create($data['table'], $data['zone']),
                $tablesWithRelations
            )
        );
    }

    public function toArray(): array
    {
        return array_map(
            fn (GetTableByIDResponse $table) => $table->toArray(),
            $this->allTables
        );
    }
}
