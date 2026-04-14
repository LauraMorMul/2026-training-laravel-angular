<?php

namespace App\Families\Application\CreateFamily;

use App\Families\Domain\Entity\Family;
use App\Families\Domain\Interfaces\FamilyRepositoryInterface;
use App\Shared\Domain\ValueObject\Name;
use App\Shared\Domain\ValueObject\RestaurantID;

class CreateFamily
{
    public function __construct(
        private FamilyRepositoryInterface $familyRepository,
    ){}

    public function __invoke(int $restaurantID, string $name, bool $active): CreateFamilyResponse
    {
        $restaurantIDVO = RestaurantID::create($restaurantID);
        $nameVO = Name::create($name);
        $family = Family::dddCreate($restaurantIDVO, $nameVO, $active);
        $this->familyRepository->save($family);

        return CreateFamilyResponse::create($family);
    }
}