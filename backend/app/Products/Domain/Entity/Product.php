<?php

namespace App\Products\Domain\Entity;

use App\Products\Domain\ValueObject\FamilyID;
use App\Products\Domain\ValueObject\Stock;
use App\Products\Domain\ValueObject\TaxID;
use App\Shared\Domain\ValueObject\DomainDateTime;
use App\Shared\Domain\ValueObject\ImageSrc;
use App\Shared\Domain\ValueObject\Name;
use App\Shared\Domain\ValueObject\Price;
use App\Shared\Domain\ValueObject\RestaurantID;
use App\Shared\Domain\ValueObject\Uuid;

class Product
{
    private function __construct(
        private Uuid $id,
        private RestaurantID $restaurantID,
        private FamilyID $familyID,
        private TaxID $taxID,
        private ImageSrc $imageSrc,
        private Name $name,
        private Price $price,
        private Stock $stock,
        private bool $active,
        private DomainDateTime $createdAt,
        private DomainDateTime $updatedAt,
    ){}

    public static function dddCreate(RestaurantID $restaurantID, FamilyID $familyID, TaxID $taxID, ImageSrc $imageSrc, Name $name, Price $price, Stock $stock, bool $active): self
    {
        $now = DomainDateTime::now();

        return new self(
            Uuid::generate(),
            $restaurantID,
            $familyID,
            $taxID,
            $imageSrc,
            $name,
            $price,
            $stock,
            $active,
            $now,
            $now
        );
    }

    public static function fromPersistence(
        string $id,
        int $restaurantID,
        int $familyID,
        int $taxID,
        string $imageSrc,
        string $name,
        int $price,
        int $stock,
        bool $active,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt,
    ): self {
        return new self(
            Uuid::create($id),
            RestaurantID::create($restaurantID),
            FamilyID::create($familyID),
            TaxID::create($taxID),
            ImageSrc::create($imageSrc),
            Name::create($name),
            Price::create($price),
            Stock::create($stock),
            boolval($active),
            DomainDateTime::create($createdAt),
            DomainDateTime::create($updatedAt),
        );
    }

    public function updateData(
        ImageSrc $imageSrc,
        Name $name, 
        Price $price,
        Stock $stock,
        bool $active
    ): self
    {
        return new self(
            $this->id,
            $this->restaurantID,
            $this->familyID,
            $this->taxID,
            $imageSrc,
            $name,
            $price,
            $stock,
            $active,
            $this->createdAt,
            DomainDateTime::now(),
        );
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function restaurantID(): RestaurantID
    {
        return $this->restaurantID;
    }

    public function familyID(): FamilyID
    {
        return $this->familyID;
    }

    public function taxID(): TaxID
    {
        return $this->taxID;
    }

    public function imageSrc(): ImageSrc
    {
        return $this->imageSrc;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function price(): Price
    {
        return $this->price;
    }

    public function stock(): Stock
    {
        return $this->stock;
    }

    public function active(): bool
    {
        return $this->active;
    }

    public function createdAt(): DomainDateTime
    {
        return $this->createdAt;
    }

    public function updatedAt(): DomainDateTime
    {
        return $this->updatedAt;
    }
}