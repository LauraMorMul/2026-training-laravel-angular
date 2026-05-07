<?php

namespace App\User\Application\LoginUser;

use App\User\Domain\Entity\User;

final readonly class LoginUserResponse
{
    private function __construct(
        private string $id,
        private int $restaurantID,
        private string $role,
        private ?string $imageSrc,
        private string $name,
        private string $email,
        private string $pin,
        private string $createdAt,
        private string $updatedAt,
        private string $token,
    ) {}

    public static function create(User $user, string $token): self
    {
        return new self(
            id: $user->id()->value(),
            restaurantID: $user->restaurantID()->value(),
            role: $user->role()->value(),
            imageSrc: $user->imageSrc()->value(),
            name: $user->name()->value(),
            email: $user->email()->value(),
            pin: $user->pin()->value(),
            createdAt: $user->createdAt()->format(\DateTimeInterface::ATOM),
            updatedAt: $user->updatedAt()->format(\DateTimeInterface::ATOM),
            token: $token,
        );
    }

    public function toArray(): array
    {
        return [
            'token' => $this->token,
            'user' => [
                'id' => $this->id,
                'restaurant_id' => $this->restaurantID,
                'role' => $this->role,
                'imageSrc' => $this->imageSrc,
                'name' => $this->name,
                'email' => $this->email,
                'pin' => $this->pin,
                'created_at' => $this->createdAt,
                'updated_at' => $this->updatedAt,
            ],
        ];
    }
}
