<?php

namespace App\Family\Domain\Services;

use App\Family\Domain\Interfaces\FamilyRepositoryInterface;
use App\Shared\Domain\Interfaces\TransactionManagerInterface;

class DeleteFamilyService
{
    public function __construct(
        private FamilyRepositoryInterface $familyRepository,
        private TransactionManagerInterface $transactionManager
    ) {}

    public function execute(string $id, int $restaurantId): void
    {
        $this->transactionManager->execute(
            function () use ($id, $restaurantId) {
                $this->familyRepository->deleteByID($id, $restaurantId);
            }
        );
    }
}
