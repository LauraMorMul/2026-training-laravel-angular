<?php

namespace App\Shared\Domain\Interfaces;

interface PasswordHasherInterface
{
    public function hash(string $plainPassword): string;
}
