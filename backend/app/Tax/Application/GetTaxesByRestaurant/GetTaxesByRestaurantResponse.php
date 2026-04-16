<?php

namespace App\Tax\Application\GetTaxesByRestaurant;

use App\Tax\Application\GetTaxByID\GetTaxByIDResponse;
use App\Tax\Domain\Entity\Tax;

final readonly class GetTaxesByRestaurantResponse
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