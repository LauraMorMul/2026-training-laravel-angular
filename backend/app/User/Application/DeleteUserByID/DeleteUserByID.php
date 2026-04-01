<?php

namespace App\User\Application\DeleteUserByID;

use App\User\Domain\Interfaces\UserRepositoryInterface;

class DeleteUserByID
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(string $id): string
    {
        $deleted = $this->userRepository->deleteByID($id);

        return $deleted;
    }
}