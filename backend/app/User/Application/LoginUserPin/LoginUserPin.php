<?php

namespace App\User\Application\LoginUserPin;

use App\Shared\Domain\Interfaces\PasswordHasherInterface;
use App\User\Domain\Interfaces\TokenManagerInterface;
use App\User\Domain\Interfaces\UserRepositoryInterface;
use Illuminate\Validation\ValidationException;

class LoginUserPin
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private PasswordHasherInterface $passwordHasher,
        private TokenManagerInterface $tokenManager,
    ) {}

    public function __invoke(string $email, string $pin, int $id): LoginUserPinResponse
    {
        $user = $this->userRepository->findByEmailAndRestaurant($email, $id);
        if ($user === null || ! $user->pin()->value() === $pin) {
            throw ValidationException::withMessages([
                'Login' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $this->tokenManager->issueToken($user, $user->role()->value());

        return LoginUserPinResponse::create($user, $token);
    }
}
