<?php

namespace App\Shared\Domain\ValueObject;

class InternalID extends AbstractPositiveInteger
{
    protected function errorMessage(): string
    {
        return 'Internal ID must be a positive integer.';
    }
}
