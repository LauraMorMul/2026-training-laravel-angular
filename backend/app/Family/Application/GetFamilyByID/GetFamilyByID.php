<?php

namespace App\Family\Application\GetFamilyByID;

use App\Family\Domain\Interfaces\FamilyRepositoryInterface;

class GetFamilyByID
{
    public function __construct(
        private FamilyRepositoryInterface $familyRepository
    ) {}

    public function __invoke(string $id, int $restaurantId): ?GetFamilyByIDResponse
    {
        $family = $this->familyRepository->findByID($id);

        if ($family == null || $family->restaurantID()->value() !== $restaurantId) {
            return null;
        } else {
            return GetFamilyByIDResponse::create($family);
        }
    }
}
