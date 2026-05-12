<?php

namespace App\Tax\Domain\Exceptions;

class TaxHasRelatedProductsException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('Tax is in use with at least one product.');
    }
}
