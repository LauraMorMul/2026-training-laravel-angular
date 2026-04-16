<?php

namespace App\Product\Domain\ValueObject;

class Stock
{
    private int $value;

    private function __construct(int $value)
    {
        if($value < 0) {
            throw new \InvalidArgumentException('Stock shouldn\'t be negative.');
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