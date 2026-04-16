<?php

namespace App\Tax\Domain\ValueObject;

class Percentage
{
    private int $value;

    private function __construct(int $value)
    {
        if($value < 0) {
            throw new \InvalidArgumentException('Percentace can\'t be negative.');
        }

        if($value > 100) {
            throw new \InvalidArgumentException('Percentace shouldn\'t be higher than 100.');
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