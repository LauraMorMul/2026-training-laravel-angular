<?php

namespace App\Product\Application\UpdateProduct;

use App\Family\Domain\Interfaces\FamilyRepositoryInterface;
use App\Product\Domain\Interfaces\ProductRepositoryInterface;
use App\Product\Domain\ValueObject\FamilyID;
use App\Product\Domain\ValueObject\Stock;
use App\Product\Domain\ValueObject\TaxID;
use App\Shared\Domain\ValueObject\ImageSrc;
use App\Shared\Domain\ValueObject\Name;
use App\Shared\Domain\ValueObject\Price;
use App\Tax\Domain\Interfaces\TaxRepositoryInterface;

class UpdateProduct
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private FamilyRepositoryInterface $familyRepository,
        private TaxRepositoryInterface $taxesRepository
    ) {}

    public function __invoke(string $uuid, ?string $familyUUID, ?string $taxUUID, ?string $imageSrc, ?string $name, ?int $price, ?int $stock, ?bool $active, int $restaurantID)
    {
        $product = $this->productRepository->findById($uuid);

        if ($product == null || $product->restaurantID()->value() !== $restaurantID) {
            return null;
        }

        $restaurantFamily = $this->familyRepository->findById($familyUUID)->restaurantID()->value();
        $restaurantTax = $this->taxesRepository->findById($taxUUID)->restaurantID()->value();

        if ($restaurantFamily != $restaurantID || $restaurantTax != $restaurantID) {
            return null;
        }

        if ($familyUUID === null) {
            $familyIDVO = $product->familyID();
        } else {
            $familyID = $this->familyRepository->findIDbyUUID($familyUUID);
            $familyIDVO = FamilyID::create($familyID);
        }

        if ($taxUUID === null) {
            $taxIDVO = $product->taxID();
        } else {
            $taxID = $this->taxesRepository->findIDbyUUID($taxUUID);
            $taxIDVO = TaxID::create($taxID);
        }

        if ($imageSrc === null) {
            $imageSrcVO = $product->imageSrc();
        } else {
            $imageSrcVO = ImageSrc::create($imageSrc);
        }

        if ($name === null) {
            $nameVO = $product->name();
        } else {
            $nameVO = Name::create($name);
        }

        if ($price === null) {
            $priceVO = $product->price();
        } else {
            $priceVO = Price::create($price);
        }

        if ($stock === null) {
            $stockVO = $product->stock();
        } else {
            $stockVO = Stock::create($stock);
        }

        if ($active === null) {
            $isActive = $product->active();
        } else {
            $isActive = $active;
        }

        $product = $product->updateData($familyIDVO, $taxIDVO, $imageSrcVO, $nameVO, $priceVO, $stockVO, $isActive);
        $this->productRepository->save($product);

        return UpdateProductResponse::create($product);
    }
}
