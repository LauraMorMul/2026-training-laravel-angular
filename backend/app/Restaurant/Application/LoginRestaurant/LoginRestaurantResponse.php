<?php

namespace App\Restaurant\Application\LoginRestaurant;

use App\Restaurant\Domain\Entity\Restaurant;

final readonly class LoginRestaurantResponse
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
        public string $token,
    ) {}

    public static function create(Restaurant $restaurant, string $token): self
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
            token: $token,
        );
    }

    public function toArray(): array
    {
        return [
            'token' => $this->token,
            'restaurant' => [
                'id' => $this->id,
                'name' => $this->name,
                'legal_name' => $this->legalName,
                'tax_ID' => $this->taxID,
                'email' => $this->email,
                'created_at' => $this->createdAt,
                'updated_at' => $this->updatedAt,
            ],
        ];
    }
}
