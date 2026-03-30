<?php

namespace App\User\Application\CreateUser;

use App\User\Domain\Entity\User;

final readonly class CreateUserResponse
{
    public function __construct(
        public string $id,
        public string $role,
        public string $imageSrc,
        public string $name,
        public string $email,
        public string $pin,
        public string $createdAt,
        public string $updatedAt,
    ) {}

    public static function create(User $user): self
    {
        return new self(
            id: $user->id()->value(),
            role: $user->role(),
            imageSrc: $user->imageSrc(),
            name: $user->name(),
            email: $user->email()->value(),
            pin: $user->pin(),
            createdAt: $user->createdAt()->format(\DateTimeInterface::ATOM),
            updatedAt: $user->updatedAt()->format(\DateTimeInterface::ATOM),
        );
    }

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'role' => $this->role,
            'imageSrc' => $this->imageSrc,
            'name' => $this->name,
            'email' => $this->email,
            'pin' => $this->pin,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
