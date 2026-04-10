<?php

namespace App\Taxes\Application\DeleteTaxByID;

use App\Taxes\Domain\Interfaces\TaxRepositoryInterface;

class DeleteTaxByID
{
    public function __construct(
        private TaxRepositoryInterface $taxRepository,
    ) {}

    public function __invoke(string $id): void
    {
        $deleted = $this->taxRepository->deleteByID($id);
    }
}