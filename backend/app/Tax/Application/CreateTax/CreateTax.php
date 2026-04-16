<?php

namespace App\Tax\Application\CreateTax;

use App\Shared\Domain\ValueObject\Name;
use App\Shared\Domain\ValueObject\RestaurantID;
use App\Tax\Domain\Entity\Tax;
use App\Tax\Domain\Interfaces\TaxRepositoryInterface;
use App\Tax\Domain\ValueObject\Percentage;

class CreateTax
{
    public function __construct(
        private TaxRepositoryInterface $taxRepository,
    ){}

    public function __invoke(int $restaurantID, string $name, int $percentage): CreateTaxResponse
    {
        $restaurantIDVO = RestaurantID::create($restaurantID);
        $nameVO = Name::create($name);
        $percentageVO = Percentage::create($percentage);
        $tax = Tax::dddCreate($restaurantIDVO, $nameVO, $percentageVO);
        $this->taxRepository->save($tax);

        return CreateTaxResponse::create($tax);
    }
}