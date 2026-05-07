<?php

namespace App\Restaurant\Application\LoginRestaurant;

use App\Restaurant\Domain\Entity\Restaurant;

final readonly class LoginRestaurantResponse
{
    private function __construct(
        private string $id,
        private string $name,
        private string $legalName,
        private string $taxID,
        private string $email,
        private string $password,
        private string $createdAt,
        private string $updatedAt,
        private string $token,
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
