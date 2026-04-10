<?php

namespace App\Taxes\Application\UpdateTax;

use App\Shared\Domain\ValueObject\Name;
use App\Taxes\Domain\Interfaces\TaxRepositoryInterface;

class UpdateTax
{
    public function __construct(
        private TaxRepositoryInterface $taxRepository,
    )
    {}

    public function __invoke(string $uuid, ?string $name, ?int $percentage): ? UpdateTaxResponse
    {
        $tax = $this->taxRepository->findById($uuid);

        if($name === null) {
            $nameVO = $tax->name();
        }else {
            $nameVO = Name::create($name);
        }

        if($percentage === null) {
            $percentageVO = $tax->percentage();
        }else {
            $percentageVO = $percentage;
        }

        $tax = $tax->updateData($nameVO, $percentageVO);
        $this->taxRepository->save($tax);

        return UpdateTaxResponse::create($tax);
    }
}