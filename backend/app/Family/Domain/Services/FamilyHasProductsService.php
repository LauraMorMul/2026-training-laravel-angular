<?php

namespace App\Family\Domain\Services;

use App\Family\Domain\Interfaces\FamilyRepositoryInterface;

class FamilyHasProductsService
{
    public function __construct(
        private FamilyRepositoryInterface $familyRepository,
    ) {}

    public function execute(string $id, int $restaurantId): bool
    {
        $family = $this->familyRepository->findFamilyWithProductsByUuid($id, $restaurantId);

        return $family !== null;
    }
}
