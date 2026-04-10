<?php

namespace App\Taxes\Application\CreateTax;

use App\Shared\Domain\ValueObject\Name;
use App\Shared\Domain\ValueObject\RestaurantID;
use App\Taxes\Domain\Entity\Tax;
use App\Taxes\Domain\Interfaces\TaxRepositoryInterface;
use App\Taxes\Domain\ValueObjects\Percentage;

class CreateTax
{
    public function __construct(
        private TaxRepositoryInterface $taxRepository,
    ){}

    public function __invoke(string $restaurantID, string $name, int $percentage): CreateTaxResponse
    {
        $restaurantIDVO = RestaurantID::create($restaurantID);
        $nameVO = Name::create($name);
        $percentageVO = Percentage::create($percentage);
        $tax = Tax::dddCreate($restaurantIDVO, $nameVO, $percentageVO);
        $this->taxRepository->save($tax);

        return CreateTaxResponse::create($tax);
    }
}