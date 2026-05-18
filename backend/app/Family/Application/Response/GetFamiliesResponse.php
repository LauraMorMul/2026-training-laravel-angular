<?php

namespace App\Family\Application\Response;

use App\Family\Domain\Entity\Family;

final readonly class GetFamiliesResponse
{
    private function __construct(
        private array $allFamilies,
    ) {}

    public static function create(array $families): self
    {
        return new self(
            allFamilies: array_map(
                fn (Family $family) => FamilyItemResponse::create($family),
                $families
            )
        );
    }

    public function toArray(): array
    {
        return array_map(
            fn (FamilyItemResponse $family) => $family->toArray(),
            $this->allFamilies
        );
    }
}
