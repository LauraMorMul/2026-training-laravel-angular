<?php

namespace App\Tax\Application\DeleteTaxByID;

use App\Tax\Domain\Interfaces\TaxRepositoryInterface;

class DeleteTaxByID
{
    public function __construct(
        private TaxRepositoryInterface $taxRepository,
    ) {}

    public function __invoke(string $id, int $restaurantID): bool
    {
        $exists = $this->taxRepository->findById($id);
        if ($exists === null || $exists->restaurantID()->value() !== $restaurantID) {
            return false;
        } else {
            $deleted = $this->taxRepository->deleteByID($id);

            return true;
        }
    }
}
