<?php

namespace App\Shared\Domain\ValueObject;

class RestaurantID
{
    private string $value;

    private function __construct(string $value)
    {
        $trimmed = trim($value);
        if($trimmed === '') {
            throw new \InvalidArgumentException('Restaurant ID is mandatory.');
        }
        if(!ctype_digit($trimmed)) {
            throw new \InvalidArgumentException('Pin has to be numeric.');
        }

        $this->value = $trimmed;
    }

    public static function crete(string $value)
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}