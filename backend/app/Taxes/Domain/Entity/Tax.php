<?php

namespace App\Taxes\Domain\Entity;

use App\Shared\Domain\ValueObject\DomainDateTime;
use App\Shared\Domain\ValueObject\Name;
use App\Shared\Domain\ValueObject\RestaurantID;
use App\Shared\Domain\ValueObject\Uuid;
use App\Taxes\Domain\ValueObject\Percentage;

class Tax
{
    private function __construct(
        private Uuid $id,
        private RestaurantID $restaurantID,
        private Name $name,
        private Percentage $percentage,
        private DomainDateTime $createdAt,
        private DomainDateTime $updatedAt
    ){}

    public static function dddCreate(RestaurantID $restaurantID, Name $name, Percentage $percentage): self
    {
        $now = DomainDateTime::now();

        return new self(
            Uuid::generate(),
            $restaurantID,
            $name,
            $percentage,
            $now,
            $now
        );
    }

    public static function fromPersistence(
        string $id,
        string $restaurantID,
        string $name,
        int $percentage,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt,
    ): self {
        return new self(
            Uuid::create($id),
            RestaurantID::create($restaurantID),
            Name::create($name),
            Percentage::create($percentage),
            DomainDateTime::create($createdAt),
            DomainDateTime::create($updatedAt),
        );
    }

    public function updateData(
        Name $name,
        Percentage $percentage,
    ): self {
        return new self(
            $this->id,
            $this->restaurantID,
            $name,
            $percentage,
            $this->createdAt,
            DomainDateTime::now(),
        );
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function restaurantID(): string
    {
        return $this->restaurantID->value();
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function percentage(): int
    {
        return $this->percentage->value();
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