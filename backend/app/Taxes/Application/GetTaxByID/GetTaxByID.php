<?php

namespace App\Taxes\Application\GetTaxByID;

use App\Taxes\Domain\Interfaces\TaxRepositoryInterface;

class GetTaxByID
{
    public function __construct(
        private TaxRepositoryInterface $taxesRepository
    ) {}

    public function __invoke(string $id): ?GetTaxByIDResponse
    {
        $tax = $this->taxesRepository->findByID($id);

        if($tax == null) {
            return null;
        } else {
            return GetTaxByIDResponse::create($tax);
        }
    }
}