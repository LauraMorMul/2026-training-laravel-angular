<?php

namespace App\Family\Application\GetFamiliesByRestaurant;

use App\Family\Application\GetFamilyByID\GetFamilyByIDResponse;
use App\Family\Domain\Entity\Family;

final readonly class GetFamiliesByRestaurantResponse
{
    public function __construct(
        private array $allFamilies,
    ) {}

    public static function create(array $families): self
    {
        return new self(
            allFamilies: array_map(
                fn (Family $family) => GetFamilyByIDResponse::create($family),
                $families
            )
        );
    }

    public function toArray(): array
    {
        return array_map(
            fn (GetFamilyByIDResponse $family) => $family->toArray(),
            $this->allFamilies
        );
    }
}
