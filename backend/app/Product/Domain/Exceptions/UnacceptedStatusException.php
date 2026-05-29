<?php

namespace App\Product\Domain\Exceptions;

class UnacceptedStatusException extends \DomainException
{
    public function __construct()
    {
        parent::__construct("That's not an accepted state");
    }
}
