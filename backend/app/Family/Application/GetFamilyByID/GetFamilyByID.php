<?php

namespace App\Family\Application\GetFamilyByID;

use App\Family\Domain\Interfaces\FamilyRepositoryInterface;

class GetFamilyByID
{
    public function __construct(
        private FamilyRepositoryInterface $familyRepository
    ) {}

    public function __invoke(string $id): ?GetFamilyByIDResponse
    {
        $family = $this->familyRepository->findByID($id);

        if ($family == null) {
            return null;
        } else {
            return GetFamilyByIDResponse::create($family);
        }
    }
}
