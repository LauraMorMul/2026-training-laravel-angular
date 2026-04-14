<?php

namespace App\Products\Application\UpdateProduct;

use App\Products\Domain\Interfaces\ProductRepositoryInterface;
use App\Products\Domain\ValueObject\Stock;
use App\Shared\Domain\ValueObject\ImageSrc;
use App\Shared\Domain\ValueObject\Name;
use App\Shared\Domain\ValueObject\Price;

class UpdateProduct
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    )
    {}

    public function __invoke(string $uuid, ?string $imageSrc, ?string $name, ?int $price, ?int $stock, ?bool $active)
    {
        $product = $this->productRepository->findById($uuid);

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

        $product = $product->updateData($imageSrcVO, $nameVO, $priceVO, $stockVO, $isActive);
        $this->productRepository->save($product);

        return UpdateProductResponse::create($product);
    }
}