<?php

namespace App\Tables\Application\GetTablesByRestaurant;

use App\Tables\Application\GetTableByID\GetTableByIDResponse;
use App\Tables\Domain\Entity\Table;

final readonly class GetTablesByRestaurantResponse
{
    public function __construct(
        private array $allTables,
    ) {}

    public static function create(array $families):self {
        return new self(
            allTables: array_map(
                fn(Table $table) => GetTableByIDResponse::create($table),
                $families
            )
        );
    }

    public function toArray(): array
    {
        return array_map(
            fn(GetTableByIDResponse $table) => $table->toArray(),
            $this->allTables
        );
    }
}