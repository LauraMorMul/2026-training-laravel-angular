<?php

namespace App\User\Infrastructure\Services;

use App\Shared\Domain\Interfaces\PasswordHasherInterface;
use App\User\Domain\Entity\User;
use App\User\Domain\Interfaces\TokenManagerInterface;
use App\User\Domain\Interfaces\UserRepositoryInterface;
use App\User\Infrastructure\Persistence\Models\EloquentUser;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class SanctumTokenManager implements TokenManagerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private PasswordHasherInterface $passwordHasher,
    ) {}

    public function registerAbilities(User $user, string $abilities): ?array
    {
        $eloquentUser = EloquentUser::where('uuid', $user->id()->value())->first();

        if ($eloquentUser === null) {
            throw new NotFoundResourceException('Usuario no encontrado');
        }

        $eloquentUser->createToken('Registration token', [$abilities]);

        return $eloquentUser->currentAccessToken()->abilities;
    }

    public function issueToken(User $user, string $abilities): string
    {
        $eloquentUser = EloquentUser::where('uuid', $user->id()->value())->first();

        if ($eloquentUser === null) {
            throw new NotFoundResourceException('Usuario no encontrado');
        }

        $token = $eloquentUser->createToken('Login token', [$abilities]);

        return $token->plainTextToken;
    }

    public function removeCurrentToken(User $user): void
    {
        $eloquentUser = EloquentUser::where('uuid', $user->id()->value())->first();

        if ($eloquentUser === null) {
            throw new NotFoundResourceException('Usuario no encontrado');
        }

        $eloquentUser->currentAccessToken()->delete();
    }

    public function removeAllTokens(User $user): void
    {
        $eloquentUser = EloquentUser::where('uuid', $user->id()->value())->first();

        if ($eloquentUser === null) {
            throw new NotFoundResourceException('Usuario no encontrado');
        }

        $eloquentUser->tokens()->delete();
    }
}
