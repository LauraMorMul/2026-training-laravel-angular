<?php

namespace App\Restaurant\Application\CreateRestaurant;

use App\Restaurant\Domain\Entity\Restaurant;

final readonly class CreateRestaurantResponse
{
    public function __construct(
        public string $id,
        public string $name,
        public string $legalName,
        public string $taxID,
        public string $email,
        public string $password,
        public string $createdAt,
        public string $updatedAt,
    ) {}

    public static function create(Restaurant $restaurant): self
    {
        return new self(
            id: $restaurant->id()->value(),
            name: $restaurant->name()->value(),
            legalName: $restaurant->legalName()->value(),
            taxID: $restaurant->taxID()->value(),
            email: $restaurant->email()->value(),
            password: $restaurant->passwordHash()->value(),
            createdAt: $restaurant->createdAt()->format(\DateTimeInterface::ATOM),
            updatedAt: $restaurant->updatedAt()->format(\DateTimeInterface::ATOM),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'legal_name' => $this->legalName,
            'tax_ID' => $this->taxID,
            'email' => $this->email,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
