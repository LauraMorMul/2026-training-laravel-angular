<?php

namespace App\Family\Domain\Services;

use App\Family\Domain\Entity\Family;
use App\Family\Domain\Interfaces\FamilyRepositoryInterface;
use App\Shared\Domain\Interfaces\TransactionManagerInterface;

class UpdateFamilyservice
{
    public function __construct(
        private FamilyRepositoryInterface $familyRepository,
        private TransactionManagerInterface $transactionManager
    ) {}

    public function execute(Family $family): void
    {
        $this->transactionManager->execute(
            function () use ($family) {
                $this->familyRepository->save($family);
            }
        );
    }
}
