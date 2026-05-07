<?php

namespace App\Restaurant\Application\CreateRestaurant;

use App\Restaurant\Domain\Entity\Restaurant;
use App\User\Domain\Entity\User;

final readonly class CreateRestaurantResponse
{
    private function __construct(
        // Datos del restaurante
        private string $restaurantId,
        private string $restaurantName,
        private string $restaurantLegalName,
        private string $restaurantTaxID,
        private string $restaurantEmail,
        private string $restaurantCreatedAt,
        private string $restaurantUpdatedAt,
        // Datos del usuario administrador
        private string $adminId,
        private string $adminName,
        private string $adminEmail,
        private string $adminRole,
        private ?string $adminImageSrc,
        private string $adminPin,
        private string $adminCreatedAt,
        private string $adminUpdatedAt,
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
