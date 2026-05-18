<?php

namespace App\Family\Domain\Services;

use App\Family\Domain\Interfaces\FamilyRepositoryInterface;

class GetFamiliesService
{
    public function __construct(
        private FamilyRepositoryInterface $familyRepository
    ) {}

    public function execute(int $restaurantId)
    {
        return $this->familyRepository->getByRestaurant($restaurantId);
    }
}
