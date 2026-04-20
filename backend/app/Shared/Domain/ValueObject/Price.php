<?php

namespace App\Shared\Domain\ValueObject;

class Price
{
    private int $value;

    private function __construct(int $value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('Price can\'t be negative.');
        }

        $this->value = $value;
    }

    public static function create(int $value)
    {
        return new self($value);
    }

    public function value(): int
    {
        return $this->value;
    }
}
