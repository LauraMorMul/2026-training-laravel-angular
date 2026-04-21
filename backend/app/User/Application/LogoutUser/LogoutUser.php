<?php

namespace App\User\Application\LogoutUser;

use App\User\Domain\Entity\User;
use App\User\Domain\Interfaces\TokenManagerInterface;
use App\User\Domain\Interfaces\UserRepositoryInterface;

class LogoutUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private TokenManagerInterface $tokenManager,
    ) {}

    public function __invoke(User $user)
    {
        $this->tokenManager->removeCurrentToken($user);
    }
}
