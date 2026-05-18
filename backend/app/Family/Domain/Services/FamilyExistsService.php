<?php

namespace App\Family\Domain\Services;

use App\Family\Domain\Interfaces\FamilyRepositoryInterface;

class FamilyExistsService
{
    public function __construct(
        private FamilyRepositoryInterface $familyRepository,
    ) {}

    public function execute(string $id, int $restaurantId)
    {
        $family = $this->familyRepository->findById($id, $restaurantId);

        return $family !== null;
    }
}
