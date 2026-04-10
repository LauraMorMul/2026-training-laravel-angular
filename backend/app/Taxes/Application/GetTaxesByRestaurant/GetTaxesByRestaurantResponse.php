<?php

namespace App\Taxes\Application\GetTaxesByRestaurant;

use App\Taxes\Application\GetTaxByID\GetTaxByIDResponse;
use App\Taxes\Domain\Entity\Tax;

class GetTaxesByRestaurantResponse
{
    public function __construct(
        private array $allTaxes,
    ) {}

    public static function create(array $taxes):self {
        return new self(
            allTaxes: array_map(
                fn(Tax $tax) => GetTaxByIDResponse::create($tax),
                $taxes
            )
        );
    }

    public function toArray(): array
    {
        return array_map(
            fn(GetTaxByIDResponse $tax) => $tax->toArray(),
            $this->allTaxes
        );
    }
}