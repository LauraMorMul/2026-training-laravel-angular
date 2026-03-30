<?php

namespace App\User\Application\GetUser;

use App\User\Application\CreateUser\GetUserByIDResponse;
use App\User\Domain\Interfaces\PasswordHasherInterface;
use App\User\Domain\Interfaces\UserRepositoryInterface;

class GetUserByID
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(string $id): GetUserByIDResponse
    {
        $user = $this->userRepository->findByID($id);

        return GetUserByIDResponse::create($user);
    }
}
