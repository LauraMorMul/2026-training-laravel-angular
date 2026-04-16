<?php

namespace App\Product\Application\CreateProduct;

use App\Product\Domain\Entity\Product;
use App\Product\Domain\Interfaces\ProductRepositoryInterface;
use App\Product\Domain\ValueObject\FamilyID;
use App\Product\Domain\ValueObject\Stock;
use App\Product\Domain\ValueObject\TaxID;
use App\Shared\Domain\ValueObject\ImageSrc;
use App\Shared\Domain\ValueObject\Name;
use App\Shared\Domain\ValueObject\Price;
use App\Shared\Domain\ValueObject\RestaurantID;

class CreateProduct
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
    ){}

    public function __invoke(int $restaurantID, int $familyID, int $taxID, string $imageSrc, string $name, int $price, int $stock, bool $active): CreateProductResponse
    {
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