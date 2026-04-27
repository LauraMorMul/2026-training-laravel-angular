<?php

namespace App\Tax\Application\GetTaxByID;

use App\Tax\Domain\Interfaces\TaxRepositoryInterface;

class GetTaxByID
{
    public function __construct(
        private TaxRepositoryInterface $taxesRepository
    ) {}

    public function __invoke(string $id, int $restaurantID): ?GetTaxByIDResponse
    {
        $tax = $this->taxesRepository->findByID($id);

        if ($tax == null || $tax->restaurantID()->value() !== $restaurantID) {
            return null;
        } else {
            return GetTaxByIDResponse::create($tax);
        }
    }
}
