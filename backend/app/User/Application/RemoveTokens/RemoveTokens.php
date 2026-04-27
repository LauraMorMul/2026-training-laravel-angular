<?php

namespace App\User\Application\RemoveTokens;

use App\User\Domain\Interfaces\TokenManagerInterface;

class RemoveTokens
{
    public function __construct(
        private TokenManagerInterface $tokenManager,
    ) {}

    public function __invoke()
    {
        $this->tokenManager->removeAllTokens();
    }
}
