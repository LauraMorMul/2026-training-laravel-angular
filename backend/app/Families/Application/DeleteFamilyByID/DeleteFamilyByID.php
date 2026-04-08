<?php

namespace App\Families\Application\DeleteFamilyByID;

use App\Families\Domain\Interfaces\FamilyRepositoryInterface;

class DeleteFamilyByID
{
    public function __construct(
        private FamilyRepositoryInterface $familyRepository,
    ) {}

    public function __invoke(string $id): void
    {
        $deleted = $this->familyRepository->deleteByID($id);
    }
}