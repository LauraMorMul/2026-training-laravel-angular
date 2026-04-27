<?php

namespace App\User\Application\GetUserByID;

use App\User\Domain\Interfaces\UserRepositoryInterface;

class GetUserByID
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(string $id, int $restaurantID): ?GetUserByIDResponse
    {
        $user = $this->userRepository->findByID($id);

        if ($user == null || $user->restaurantID()->value() !== $restaurantID) {
            return null;
        } else {
            return GetUserByIDResponse::create($user);
        }
    }
}
