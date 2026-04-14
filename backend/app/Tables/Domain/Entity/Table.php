<?php

namespace App\Tables\Domain\Entity;

use App\Shared\Domain\ValueObject\DomainDateTime;
use App\Shared\Domain\ValueObject\Name;
use App\Shared\Domain\ValueObject\RestaurantID;
use App\Shared\Domain\ValueObject\Uuid;
use App\Tables\Domain\ValueObject\ZoneID;

class Table
{
    private function __construct(
        private Uuid $id,
        private RestaurantID $restaurantId,
        private ZoneID $zoneId,
        private Name $name,
        private DomainDateTime $createdAt,
        private DomainDateTime $updatedAt,
    )
    {}

    public static function dddCreate(RestaurantID $restaurantID, ZoneID $zoneId, Name $name): self
    {
        $now = DomainDateTime::now();

        return new self(
            Uuid::generate(),
            $restaurantID,
            $zoneId,
            $name,
            $now,
            $now
        );
    }

    public static function fromPersistence(
        string $id,
        int $restaurantID,
        int $zoneId,
        string $name,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt,
    ): self {
        return new self(
            Uuid::create($id),
            RestaurantID::create($restaurantID),
            ZoneID::create($zoneId),
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
            $this->restaurantId,
            $this->zoneId,
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
        return $this->restaurantId;
    }

    public function zoneID(): ZoneID
    {
        return $this->zoneId;
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