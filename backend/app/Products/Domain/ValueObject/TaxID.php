<?php

namespace App\Products\Domain\ValueObject;

class TaxID
{
    private string $value;

    private function __construct(string $value)
    {
        $trimmed = trim($value);
        if($trimmed === '') {
            throw new \InvalidArgumentException('Tax ID is mandatory.');
        }
        if(!ctype_digit($trimmed)) {
            throw new \InvalidArgumentException('Remember, it uses the internal ID.');
        }

        $this->value = $trimmed;
    }

    public static function create(string $value)
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}