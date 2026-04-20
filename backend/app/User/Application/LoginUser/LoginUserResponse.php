<?php

namespace App\User\Application\LoginUser;

use App\User\Domain\Entity\User;

final readonly class LoginUserResponse
{
    public function __construct(
        public string $id,
        public int $restaurantID,
        public string $role,
        public string $imageSrc,
        public string $name,
        public string $email,
        public string $pin,
        public string $createdAt,
        public string $updatedAt,
        public string $token,
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
