<?php

namespace App\Family\Application\DeleteFamilyByID;

use App\Family\Domain\Exceptions\FamilyHasProductsException;
use App\Family\Domain\Interfaces\FamilyRepositoryInterface;
use App\Product\Domain\Interfaces\ProductRepositoryInterface;
use App\Shared\Domain\Exceptions\EntityNotFoundException;
use App\Shared\Domain\Exceptions\WrongRestaurantException;

class DeleteFamilyByID
{
    public function __construct(
        private FamilyRepositoryInterface $familyRepository,
        private ProductRepositoryInterface $productRepository
    ) {}

    public function __invoke(string $id, int $restaurantID)
    {
        $foundFamily = $this->familyRepository->findById($id);
        if ($foundFamily === null) {
            throw new EntityNotFoundException;
        }

        if ($foundFamily->restaurantID()->value() !== $restaurantID) {
            throw new WrongRestaurantException;
        }

        $familyInternalID = $this->familyRepository->findIDbyUUID($id);
        $productsInFamily = $this->productRepository->getByFamily($familyInternalID);
        if (count($productsInFamily) > 0) {
            throw new FamilyHasProductsException;
        } else {
            $this->familyRepository->deleteByID($id);
        }
    }
}
