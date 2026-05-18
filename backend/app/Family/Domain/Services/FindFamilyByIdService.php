<?php

namespace App\Family\Domain\Services;

use App\Family\Domain\Interfaces\FamilyRepositoryInterface;
use App\Shared\Domain\Interfaces\TransactionManagerInterface;

class FindFamilyByIdService
{
    public function __construct(
        private FamilyRepositoryInterface $familyRepository,
        private TransactionManagerInterface $transactionManager
    ) {}

    public function execute(string $id, int $restaurantId)
    {
        $family = $this->familyRepository->findById($id, $restaurantId);

        return $family;
    }
}
