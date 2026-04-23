<?php

namespace App\Family\Application\DeleteFamilyByID;

use App\Family\Domain\Interfaces\FamilyRepositoryInterface;
use InvalidArgumentException;

class DeleteFamilyByID
{
    public function __construct(
        private FamilyRepositoryInterface $familyRepository,
    ) {}

    public function __invoke(string $id): void
    {
        $exists = $this->familyRepository->findById($id);
        if($exists === null) {
            throw new InvalidArgumentException("Family doesn't exist or is already deleted.");
        } else {
            $deleted = $this->familyRepository->deleteByID($id);
        }
    }
}
