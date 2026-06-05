<?php

namespace App\Sale\Domain\Entity;

use App\Order\Domain\ValueObject\OrderID;
use App\Sale\Domain\ValueObject\TicketNumber;
use App\Shared\Domain\ValueObject\DomainDateTime;
use App\Shared\Domain\ValueObject\Price;
use App\Shared\Domain\ValueObject\RestaurantID;
use App\Shared\Domain\ValueObject\UserID;
use App\Shared\Domain\ValueObject\Uuid;

class Sale
{
    private function __construct(
        private Uuid $id,
        private RestaurantID $restaurantId,
        private OrderID $orderId,
        private UserID $userId,
        private TicketNumber $ticketNumber,
        private DomainDateTime $valueDate,
        private Price $total,
        private DomainDateTime $createdAt,
        private DomainDateTime $updatedAt,
        private ?array $saleLines = null,
    ) {}

    public static function dddCreate(RestaurantID $restaurantId, OrderID $orderId, UserID $userId, TicketNumber $ticketNumber, DomainDateTime $valueDate, Price $total): self
    {
        $now = DomainDateTime::now();

        return new self(
            Uuid::generate(),
            $restaurantId,
            $orderId,
            $userId,
            $ticketNumber,
            $valueDate,
            $total,
            $now,
            $now,
            null,
        );
    }

    public static function fromPersistence(
        string $id,
        int $restaurantId,
        int $orderId,
        int $userId,
        int $ticketNumber,
        \DateTimeImmutable $valueDate,
        int $total,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt,
        ?array $saleLines = null,
    ): self {
        return new self(
            Uuid::create($id),
            RestaurantID::create($restaurantId),
            OrderID::create($orderId),
            UserID::create($userId),
            TicketNumber::create('T-'.$ticketNumber),
            DomainDateTime::create($valueDate),
            Price::create($total),
            DomainDateTime::create($createdAt),
            DomainDateTime::create($updatedAt),
            $saleLines,
        );
    }

    public function updateData(
        UserID $userId,
        TicketNumber $ticketNumber,
        DomainDateTime $valueDate,
        Price $total
    ): self {
        return new self(
            $this->id,
            $this->restaurantId,
            $this->orderId,
            $userId,
            $ticketNumber,
            $valueDate,
            $total,
            $this->createdAt,
            DomainDateTime::now(),
            $this->saleLines,
        );
    }

    public function withSaleLines(array $saleLines): self
    {
        return new self(
            $this->id,
            $this->restaurantId,
            $this->orderId,
            $this->userId,
            $this->ticketNumber,
            $this->valueDate,
            $this->total,
            $this->createdAt,
            $this->updatedAt,
            $saleLines,
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

    public function userId(): UserID
    {
        return $this->userId;
    }

    public function ticketNumber(): TicketNumber
    {
        return $this->ticketNumber;
    }

    public function valueDate(): DomainDateTime
    {
        return $this->valueDate;
    }

    public function total(): Price
    {
        return $this->total;
    }

    public function createdAt(): DomainDateTime
    {
        return $this->createdAt;
    }

    public function updatedAt(): DomainDateTime
    {
        return $this->updatedAt;
    }

    public function saleLines(): ?array
    {
        return $this->saleLines;
    }

    public function getSaleLines(): ?array
    {
        return $this->saleLines();
    }
}
