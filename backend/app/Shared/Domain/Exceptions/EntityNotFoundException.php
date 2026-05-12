<?php

namespace App\Shared\Domain\Exceptions;

class EntityNotFoundException extends \DomainException
{
    public function __construct()
    {
        parent::__construct("Entity can't be found.");
    }
}
