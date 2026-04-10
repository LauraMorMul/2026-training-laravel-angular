<?php

namespace App\Families\Domain\Entity;

use App\Shared\Domain\ValueObject\DomainDateTime;
use App\Shared\Domain\ValueObject\Name;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Domain\ValueObject\RestaurantID;

class Family
{
    private function __construct(
        private Uuid $id,
        private RestaurantID $restaurantID,
        private Name $name,
        private bool $active,
        private DomainDateTime $createdAt,
        private DomainDateTime $updatedAt,
    ) {}

    public static function dddCreate(RestaurantID $restaurantID, Name $name, bool $active): self
    {
        $now = DomainDateTime::now();

        return new self(
            Uuid::generate(),
            $restaurantID,
            $name,
            $active,
            $now,
            $now,
        );
    }

    public static function fromPersistence(
        string $id,
        string $restaurantID,
        string $name,
        bool $active,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt,
    ): self {
        return new self(
            Uuid::create($id),
            RestaurantID::create($restaurantID),
            Name::create($name),
            boolval($active),
            DomainDateTime::create($createdAt),
            DomainDateTime::create($updatedAt),
        );
    }

    public function updateData(
        Name $name,
        bool $active,
    ): self 
    {
        return new self(
            $this->id,
            $this->restaurantID,
            $name,
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

    public function name(): Name
    {
        return $this->name;
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