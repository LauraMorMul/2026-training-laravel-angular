<?php

namespace App\User\Application\GetUserByID;

use App\User\Application\GetUserByID\GetUserByIDResponse;
use App\User\Domain\Interfaces\UserRepositoryInterface;

class GetUserByID
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(string $id): GetUserByIDResponse
    {
        $user = $this->userRepository->findByID($id);

        return GetUserByIDResponse::create($user);
    }
}
