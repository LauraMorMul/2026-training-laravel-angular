<?php

namespace App\Families\Application\GetFamiliesByRestaurant;

use App\Families\Application\GetFamilyByID\GetFamilyByIDResponse;
use App\Families\Domain\Entity\Family;

class GetFamiliesByRestaurantResponse
{
    public function __construct(
        private array $allFamilies,
    ) {}

    public static function create(array $users):self {
        return new self(
            allFamilies: array_map(
                fn(Family $family) => GetFamilyByIDResponse::create($family),
                $users
            )
        );
    }

    public function toArray(): array
    {
        return array_map(
            fn(GetFamilyByIDResponse $family) => $family->toArray(),
            $this->allFamilies
        );
    }
}