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

    public function __invoke(string $email, string $plainPassword): LoginUserResponse
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user === null || ! $this->passwordHasher->check($plainPassword, $user->passwordHash()->value())) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $this->tokenManager->issueToken($user, $user->role()->value());

        return LoginUserResponse::create($user, $token);
    }
}
