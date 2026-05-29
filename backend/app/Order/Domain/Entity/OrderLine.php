<?php

namespace App\Order\Domain\Entity;

use App\Order\Domain\ValueObject\OrderID;
use App\Order\Domain\ValueObject\ProductID;
use App\Shared\Domain\ValueObject\DomainDateTime;
use App\Shared\Domain\ValueObject\Price;
use App\Shared\Domain\ValueObject\Quantity;
use App\Shared\Domain\ValueObject\RestaurantID;
use App\Shared\Domain\ValueObject\UserID;
use App\Shared\Domain\ValueObject\Uuid;
use App\Tax\Domain\ValueObject\Percentage;

class OrderLine
{
    private function __construct(
        private Uuid $id,
        private RestaurantID $restaurantId,
        private OrderID $orderId,
        private ProductID $productId,
        private UserID $userId,
        private Quantity $quantity,
        private Price $price,
        private Percentage $taxPercentage,
        private DomainDateTime $createdAt,
        private DomainDateTime $updatedAt,
    ) {}

    public static function dddCreate(RestaurantID $restaurantId, OrderID $orderId, ProductID $productId, UserID $userId, Quantity $quantity, Price $price, Percentage $percentage): self
    {
        $now = DomainDateTime::now();

        return new self(
            Uuid::generate(),
            $restaurantId,
            $orderId,
            $productId,
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
        int $orderId,
        int $productId,
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
            OrderID::create($orderId),
            ProductID::create($productId),
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
            $this->orderId,
            $this->productId,
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

    public function orderId(): OrderID
    {
        return $this->orderId;
    }

    public function productId(): ProductID
    {
        return $this->productId;
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
