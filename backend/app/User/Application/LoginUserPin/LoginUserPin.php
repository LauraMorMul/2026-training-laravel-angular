<?php

namespace App\User\Application\LoginUserPin;

use App\User\Domain\Interfaces\TokenManagerInterface;
use App\User\Domain\Interfaces\UserRepositoryInterface;
use ErrorException;

class LoginUserPin
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private TokenManagerInterface $tokenManager,
    ) {}

    public function __invoke(string $email, string $pin, int $id): LoginUserPinResponse
    {
        $user = $this->userRepository->findByEmailAndRestaurant($email, $id);
        if ($user === null || $user->pin()->value() !== $pin) {
            dd(!$user->pin()->value() === $pin);
            throw new ErrorException('Error');
        }

        $token = $this->tokenManager->issueToken($user, $user->role()->value());

        return LoginUserPinResponse::create($user, $token);
    }
}
