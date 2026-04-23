<?php

namespace App\Product\Application\CreateProduct;

use App\Family\Domain\Interfaces\FamilyRepositoryInterface;
use App\Product\Domain\Entity\Product;
use App\Product\Domain\Interfaces\ProductRepositoryInterface;
use App\Product\Domain\ValueObject\FamilyID;
use App\Product\Domain\ValueObject\Stock;
use App\Product\Domain\ValueObject\TaxID;
use App\Shared\Domain\ValueObject\ImageSrc;
use App\Shared\Domain\ValueObject\Name;
use App\Shared\Domain\ValueObject\Price;
use App\Shared\Domain\ValueObject\RestaurantID;
use App\Tax\Domain\Interfaces\TaxRepositoryInterface;
use InvalidArgumentException;

class CreateProduct
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private FamilyRepositoryInterface $familyRepository,
        private TaxRepositoryInterface $taxesRepository
    ) {}

    public function __invoke(string $familyUUID, string $taxUUID, string $imageSrc, string $name, int $price, int $stock, bool $active, int $restaurantID): CreateProductResponse
    {
        $restaurantFamily = $this->familyRepository->findById($familyUUID)->restaurantID()->value();
        $restaurantTax = $this->taxesRepository->findById($taxUUID)->restaurantID()->value();

        if($restaurantFamily != $restaurantID || $restaurantTax != $restaurantID) {
            throw new InvalidArgumentException("Either the family ID or the tax ID are incorrect.");
        } else {
            $familyID = $this->familyRepository->findIDbyUUID($familyUUID);
            $taxID = $this->taxesRepository->findIDbyUUID($taxUUID);
        }

        $restaurantIDVO = RestaurantID::create($restaurantID);
        $familyIDVO = FamilyID::create($familyID);
        $taxIDVO = TaxID::create($taxID);
        $imageSrcVO = ImageSrc::create($imageSrc);
        $nameVO = Name::create($name);
        $priceVO = Price::create($price);
        $stockVO = Stock::create($stock);
        $product = Product::dddCreate($restaurantIDVO, $familyIDVO, $taxIDVO, $imageSrcVO, $nameVO, $priceVO, $stockVO, $active);
        $this->productRepository->save($product);

        return CreateProductResponse::create($product);
    }
}
