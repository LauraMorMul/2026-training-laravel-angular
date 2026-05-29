<?php

namespace App\Shared\Domain\ValueObject;

abstract class AbstractPositiveInteger
{
    private int $value;

    private function __construct(int $value)
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException($this->errorMessage());
        }

        $this->value = $value;
    }

    abstract protected function errorMessage(): string;

    public static function create(int $value): static
    {
        return new static($value);
    }

    public function value(): int
    {
        return $this->value;
    }
}
