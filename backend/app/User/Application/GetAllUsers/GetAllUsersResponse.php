<?php

namespace App\User\Application\GetAllUsers;

use App\User\Application\GetUserByID\GetUserByIDResponse;
use App\User\Domain\Entity\User;

final readonly class GetAllUsersResponse
{
    public function __construct(
        private array $allUsers,
    ) {}

    public static function create(array $users): self
    {
        return new self(
            allUsers: array_map(
                fn (User $user) => GetUserByIDResponse::create($user),
                $users
            )
        );
    }

    public function toArray(): array
    {
        return array_map(
            fn (GetUserByIDResponse $user) => $user->toArray(),
            $this->allUsers
        );
    }
}
