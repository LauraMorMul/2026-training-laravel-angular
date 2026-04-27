<?php

namespace App\Family\Application\DeleteFamilyByID;

use App\Family\Domain\Interfaces\FamilyRepositoryInterface;

class DeleteFamilyByID
{
    public function __construct(
        private FamilyRepositoryInterface $familyRepository,
    ) {}

    public function __invoke(string $id, int $restaurantID): bool
    {
        $exists = $this->familyRepository->findById($id);
        if ($exists === null || $exists->restaurantID()->value() !== $restaurantID) {
            return false;
        } else {
            $deleted = $this->familyRepository->deleteByID($id);

            return true;
        }
    }
}
