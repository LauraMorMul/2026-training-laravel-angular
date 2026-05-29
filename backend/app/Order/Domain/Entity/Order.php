<?php

namespace App\Order\Domain\Entity;

use App\Order\Domain\ValueObject\Diners;
use App\Order\Domain\ValueObject\Status;
use App\Order\Domain\ValueObject\TableID;
use App\Shared\Domain\ValueObject\DomainDateTime;
use App\Shared\Domain\ValueObject\RestaurantID;
use App\Shared\Domain\ValueObject\UserID;
use App\Shared\Domain\ValueObject\Uuid;

class Order
{
    private function __construct(
        private Uuid $id,
        private RestaurantID $restaurantId,
        private Status $status,
        private TableID $tableId,
        private UserID $openedByUserId,
        private ?UserID $closedByUserId,
        private Diners $diners,
        private DomainDateTime $openedAt,
        private ?DomainDateTime $closedAt,
        private DomainDateTime $createdAt,
        private DomainDateTime $updatedAt,
    ) {}

    public static function dddCreate(RestaurantID $restaurantId, Status $status, TableID $tableId, UserID $openedByUserId, Diners $diners): self
    {
        $now = DomainDateTime::now();

        return new self(
            Uuid::generate(),
            $restaurantId,
            $status,
            $tableId,
            $openedByUserId,
            null,
            $diners,
            $now,
            null,
            $now,
            $now
        );
    }

    public static function fromPersistence(
        string $id,
        int $restaurantId,
        string $status,
        int $tableId,
        int $openedByUserId,
        ?string $closedByUserId,
        int $diners,
        \DateTimeImmutable $openedAt,
        ?\DateTimeImmutable $closedAt,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt,
    ): self {
        return new self(
            Uuid::create($id),
            RestaurantID::create($restaurantId),
            Status::create($status),
            TableID::create($tableId),
            UserID::create($openedByUserId),
            $closedByUserId !== null ? UserID::create($closedByUserId) : null,
            Diners::create($diners),
            DomainDateTime::create($openedAt),
            $closedAt !== null ? DomainDateTime::create($closedAt) : null,
            DomainDateTime::create($createdAt),
            DomainDateTime::create($updatedAt)
        );
    }

    public function updateData(
        Status $status,
        TableID $tableId,
        UserID $closedByUserId,
        Diners $diners,
        DomainDateTime $closedAt
    ): self {
        return new self(
            $this->id,
            $this->restaurantId,
            $status,
            $tableId,
            $this->openedByUserId,
            $closedByUserId,
            $diners,
            $this->openedAt,
            $closedAt,
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

    public function status(): Status
    {
        return $this->status;
    }

    public function tableId(): TableID
    {
        return $this->tableId;
    }

    public function openedByUserId(): UserID
    {
        return $this->openedByUserId;
    }

    public function closedByUserId(): ?UserID
    {
        return $this->closedByUserId;
    }

    public function diners(): Diners
    {
        return $this->diners;
    }

    public function openedAt(): DomainDateTime
    {
        return $this->openedAt;
    }

    public function closedAt(): ?DomainDateTime
    {
        return $this->closedAt;
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
