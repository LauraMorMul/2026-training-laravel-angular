<?php

namespace App\Shared\Domain\ValueObject;

class Quantity extends AbstractPositiveInteger
{
    protected function errorMessage(): string
    {
        return 'Quantity must be a positive integer.';
    }
}
