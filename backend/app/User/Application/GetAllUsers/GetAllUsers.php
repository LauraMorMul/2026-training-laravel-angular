<?php

namespace App\User\Application\GetAllUsers;

use App\User\Domain\Interfaces\UserRepositoryInterface;
use App\User\Application\GetAllUsers\GetAllUsersResponse;

class GetAllUsers
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(): ?GetAllUsersResponse
    {
        $users = $this->userRepository->getAll();


        if( $users == null) {
            return null;
        } else {
            return GetAllUsersResponse::create($users);
        }
    }
}