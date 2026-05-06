<?php

namespace App\User\Domain\Exception;

class EmailInUseException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('User with this email already exists.');
    }
}
