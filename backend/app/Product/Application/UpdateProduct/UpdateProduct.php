<?php

namespace App\Product\Application\UpdateProduct;

use App\Product\Domain\Interfaces\ProductRepositoryInterface;
use App\Product\Domain\ValueObject\FamilyID;
use App\Product\Domain\ValueObject\Stock;
use App\Product\Domain\ValueObject\TaxID;
use App\Shared\Domain\ValueObject\ImageSrc;
use App\Shared\Domain\ValueObject\Name;
use App\Shared\Domain\ValueObject\Price;

class UpdateProduct
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    )
    {}

    public function __invoke(string $uuid, ?int $familyID, ?int $taxID, ?string $imageSrc, ?string $name, ?int $price, ?int $stock, ?bool $active)
    {
        $product = $this->productRepository->findById($uuid);

        if($familyID === null) {
            $familyIDVO = $product->familyID();
        }else {
            $familyIDVO = FamilyID::create($familyID);
        }

        if($taxID === null) {
            $taxIDVO = $product->taxID();
        }else {
            $taxIDVO = TaxID::create($taxID);
        }

        if($imageSrc === null) {
            $imageSrcVO = $product->imageSrc();
        }else {
            $imageSrcVO = ImageSrc::create($imageSrc);
        }

        if($name === null) {
            $nameVO = $product->name();
        }else {
            $nameVO = Name::create($name);
        }

        if($price === null) {
            $priceVO = $product->price();
        }else {
            $priceVO = Price::create($price);
        }

        if($stock === null) {
            $stockVO = $product->stock();
        }else {
            $stockVO = Stock::create($stock);
        }

        if($active === null) {
            $isActive = $product->active();
        }else {
            $isActive = $active;
        }

        $product = $product->updateData($familyIDVO, $taxIDVO, $imageSrcVO, $nameVO, $priceVO, $stockVO, $isActive);
        $this->productRepository->save($product);

        return UpdateProductResponse::create($product);
    }
}