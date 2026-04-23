<?php

namespace App\Restaurant\Application\CreateRestaurant;

use App\Restaurant\Domain\Entity\Restaurant;
use App\User\Domain\Entity\User;

final readonly class CreateRestaurantResponse
{
    public function __construct(
        // Datos del restaurante
        public string $restaurantId,
        public string $restaurantName,
        public string $restaurantLegalName,
        public string $restaurantTaxID,
        public string $restaurantEmail,
        public string $restaurantCreatedAt,
        public string $restaurantUpdatedAt,
        // Datos del usuario administrador
        public string $adminId,
        public string $adminName,
        public string $adminEmail,
        public string $adminRole,
        public ?string $adminImageSrc,
        public string $adminPin,
        public string $adminCreatedAt,
        public string $adminUpdatedAt,
    ) {}

    public static function create(Restaurant $restaurant, User $adminUser): self
    {
        return new self(
            // Restaurante
            restaurantId: $restaurant->id()->value(),
            restaurantName: $restaurant->name()->value(),
            restaurantLegalName: $restaurant->legalName()->value(),
            restaurantTaxID: $restaurant->taxID()->value(),
            restaurantEmail: $restaurant->email()->value(),
            restaurantCreatedAt: $restaurant->createdAt()->format(\DateTimeInterface::ATOM),
            restaurantUpdatedAt: $restaurant->updatedAt()->format(\DateTimeInterface::ATOM),
            // Usuario administrador
            adminId: $adminUser->id()->value(),
            adminRole: $adminUser->role()->value(),
            adminImageSrc: $adminUser->imageSrc()->value(),
            adminName: $adminUser->name()->value(),
            adminEmail: $adminUser->email()->value(),
            adminPin: $adminUser->pin()->value(),
            adminCreatedAt: $adminUser->createdAt()->format(\DateTimeInterface::ATOM),
            adminUpdatedAt: $adminUser->updatedAt()->format(\DateTimeInterface::ATOM),
        );
    }

    public function toArray(): array
    {
        return [
            'restaurant' => [
                'id' => $this->restaurantId,
                'name' => $this->restaurantName,
                'legal_name' => $this->restaurantLegalName,
                'tax_id' => $this->restaurantTaxID,
                'email' => $this->restaurantEmail,
                'created_at' => $this->restaurantCreatedAt,
                'updated_at' => $this->restaurantUpdatedAt,
            ],
            'admin_user' => [
                'id' => $this->adminId,
                'name' => $this->adminName,
                'email' => $this->adminEmail,
                'role' => $this->adminRole,
                'pin' => $this->adminPin,
                'image_src' => $this->adminImageSrc,
                'created_at' => $this->adminCreatedAt,
                'updated_at' => $this->adminUpdatedAt,
            ],
        ];
    }
}
