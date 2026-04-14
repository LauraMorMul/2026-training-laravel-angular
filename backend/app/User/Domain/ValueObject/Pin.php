<?php

namespace App\User\Domain\ValueObject;

class Pin
{
    private const MIN_LENGTH = 4;
    private const MAX_LENGTH = 6;

    private string $value;

    private function __construct(string $value)
    {
        $trimmed = trim($value);
        if($trimmed === '') {
            throw new \InvalidArgumentException('A pin is mandatory.');
        }

        if(!ctype_digit($trimmed)) {
            throw new \InvalidArgumentException('Pin has to be numeric.');
        }

        if(strlen($trimmed) < self::MIN_LENGTH || strlen($trimmed) > self::MAX_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('Length of the pin should be between %d and %d. Yours is %d', self::MIN_LENGTH, self::MAX_LENGTH, strlen($trimmed)));
        }

        $this->value = $trimmed;
    }

    public static function create(string $value)
    {
        return new self($value);
    }

    public function value():string
    {
        return $this->value;
    }
}