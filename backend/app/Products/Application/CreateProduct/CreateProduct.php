<?php

namespace App\Products\Application\CreateProduct;

use App\Products\Domain\Entity\Product;
use App\Products\Domain\Interfaces\ProductRepositoryInterface;
use App\Products\Domain\ValueObject\FamilyID;
use App\Products\Domain\ValueObject\Stock;
use App\Products\Domain\ValueObject\TaxID;
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