<?php

namespace App\User\Domain\Interfaces;

use App\User\Domain\Entity\User;

interface TokenManagerInterface
{
    public function issueToken(User $user, string $abilities): string;

    public function removeCurrentToken(): void;

    public function removeAllTokens(): void;
}
