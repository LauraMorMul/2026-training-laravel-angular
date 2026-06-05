<?php

namespace App\Sale\Domain\Entity;

use App\Sale\Domain\ValueObject\OrderLineID;
use App\Sale\Domain\ValueObject\SaleID;
use App\Shared\Domain\ValueObject\DomainDateTime;
use App\Shared\Domain\ValueObject\Price;
use App\Shared\Domain\ValueObject\Quantity;
use App\Shared\Domain\ValueObject\RestaurantID;
use App\Shared\Domain\ValueObject\UserID;
use App\Shared\Domain\ValueObject\Uuid;
use App\Tax\Domain\ValueObject\Percentage;

class SaleLine
{
    private function __construct(
        private Uuid $id,
        private RestaurantID $restaurantId,
        private SaleID $saleId,
        private OrderLineID $orderLineId,
        private UserID $userId,
        private Quantity $quantity,
        private Price $price,
        private Percentage $taxPercentage,
        private DomainDateTime $createdAt,
        private DomainDateTime $updatedAt,
    ) {}

    public static function dddCreate(RestaurantID $restaurantId, SaleID $saleId, OrderLineID $orderLineId, UserID $userId, Quantity $quantity, Price $price, Percentage $percentage): self
    {
        $now = DomainDateTime::now();

        return new self(
            Uuid::generate(),
            $restaurantId,
            $saleId,
            $orderLineId,
            $userId,
            $quantity,
            $price,
            $percentage,
            $now,
            $now,
        );
    }

    public static function fromPersistence(
        string $id,
        int $restaurantId,
        int $saleId,
        int $orderLineId,
        int $userId,
        int $quantity,
        int $price,
        int $taxPercentage,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt,
    ): self {
        return new self(
            Uuid::create($id),
            RestaurantID::create($restaurantId),
            SaleID::create($saleId),
            OrderLineID::create($orderLineId),
            UserID::create($userId),
            Quantity::create($quantity),
            Price::create($price),
            Percentage::create($taxPercentage),
            DomainDateTime::create($createdAt),
            DomainDateTime::create($updatedAt),
        );
    }

    public function updateData(
        Quantity $quantity,
        Price $price,
    ): self {
        return new self(
            $this->id,
            $this->restaurantId,
            $this->saleId,
            $this->orderLineId,
            $this->userId,
            $quantity,
            $price,
            $this->taxPercentage,
            $this->createdAt,
            DomainDateTime::now()
        );
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function restaurantID(): RestaurantID
    {
        return $this->restaurantId;
    }

    public function saleId(): SaleID
    {
        return $this->saleId;
    }

    public function orderLineId(): OrderLineID
    {
        return $this->orderLineId;
    }

    public function userId(): UserID
    {
        return $this->userId;
    }

    public function quantity(): Quantity
    {
        return $this->quantity;
    }

    public function price(): Price
    {
        return $this->price;
    }

    public function taxPercentage(): Percentage
    {
        return $this->taxPercentage;
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
