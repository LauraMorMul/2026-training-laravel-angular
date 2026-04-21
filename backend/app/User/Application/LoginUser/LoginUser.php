<?php

namespace App\User\Application\LoginUser;

use App\Shared\Domain\Interfaces\PasswordHasherInterface;
use App\User\Domain\Interfaces\TokenManagerInterface;
use App\User\Domain\Interfaces\UserRepositoryInterface;
use Illuminate\Validation\ValidationException;

class LoginUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private PasswordHasherInterface $passwordHasher,
        private TokenManagerInterface $tokenManager,
    ) {}

    public function __invoke(string $email, string $plainPassword, int $id): LoginUserResponse
    {
        $user = $this->userRepository->findByEmailAndRestaurant($email, $id);

        if ($user === null || ! $this->passwordHasher->check($plainPassword, $user->passwordHash()->value())) {
            throw ValidationException::withMessages([
                'Login' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $this->tokenManager->issueToken($user, $user->role()->value());

        return LoginUserResponse::create($user, $token);
    }
}
