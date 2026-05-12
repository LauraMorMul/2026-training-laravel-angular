<?php

namespace App\Family\Domain\Exceptions;

class FamilyHasProductsException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('Family has products.');
    }
}
