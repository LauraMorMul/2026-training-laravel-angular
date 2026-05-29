<?php

namespace App\Order\Domain\ValueObject;

class Diners
{
    private int $value;

    private function __construct(int $value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('There should be at least one person.');
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
