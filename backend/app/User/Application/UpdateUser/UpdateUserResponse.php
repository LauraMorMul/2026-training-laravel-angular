<?php

namespace App\User\Application\UpdateUser;

use App\User\Domain\Entity\User;

class UpdateUserResponse
{
    /**
     * Create a new class instance.
     */
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

    public static function create(User $user):self
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
