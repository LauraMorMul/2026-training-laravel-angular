<?php

namespace App\Zone\Domain\Entity;

use App\Shared\Domain\ValueObject\DomainDateTime;
use App\Shared\Domain\ValueObject\Name;
use App\Shared\Domain\ValueObject\RestaurantID;
use App\Shared\Domain\ValueObject\Uuid;

class Zone
{
    private function __construct(
        private Uuid $id,
        private RestaurantID $restaurantID,
        private Name $name,
        private DomainDateTime $createdAt,
        private DomainDateTime $updatedAt,
    )
    {}

    public static function dddCreate(RestaurantID $restaurantID, Name $name): self
    {
        $now = DomainDateTime::now();

        return new self(
            Uuid::generate(),
            $restaurantID,
            $name,
            $now,
            $now
        );
    }

    public static function fromPersistence(
        string $id,
        int $restaurantID,
        string $name,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt,
    ): self {
        return new self(
            Uuid::create($id),
            RestaurantID::create($restaurantID),
            Name::create($name),
            DomainDateTime::create($createdAt),
            DomainDateTime::create($updatedAt),
        );
    }

    public function updateData(
        Name $name,
    ): self
    {
        return new self(
            $this->id,
            $this->restaurantID,
            $name,
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

    public function name(): Name
    {
        return $this->name;
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