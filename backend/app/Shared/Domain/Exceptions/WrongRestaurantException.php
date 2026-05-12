<?php

namespace App\Shared\Domain\Exceptions;

class WrongRestaurantException extends \DomainException
{
    public function __construct()
    {
        parent::__construct("The entity isn't from the same restaurant as the user.");
    }
}
