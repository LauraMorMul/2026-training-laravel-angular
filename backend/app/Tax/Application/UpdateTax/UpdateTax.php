<?php

namespace App\Tax\Application\UpdateTax;

use App\Shared\Domain\ValueObject\Name;
use App\Tax\Domain\Interfaces\TaxRepositoryInterface;
use App\Tax\Domain\ValueObject\Percentage;

class UpdateTax
{
    public function __construct(
        private TaxRepositoryInterface $taxRepository,
    ) {}

    public function __invoke(string $uuid, ?string $name, ?int $percentage, int $restaurantID): ?UpdateTaxResponse
    {
        $tax = $this->taxRepository->findById($uuid);

        if($tax ===null || $tax->restaurantID()->value() !== $restaurantID) {
            return null;
        }

        if ($name === null) {
            $nameVO = $tax->name();
        } else {
            $nameVO = Name::create($name);
        }

        if ($percentage === null) {
            $percentageVO = $tax->percentage();
        } else {
            $percentageVO = Percentage::create($percentage);
        }

        $tax = $tax->updateData($nameVO, $percentageVO);
        $this->taxRepository->save($tax);

        return UpdateTaxResponse::create($tax);
    }
}
