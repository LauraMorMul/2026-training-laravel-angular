<?php

namespace App\Restaurants\Domain\ValueObject;

class TaxID
{
    //No se hacen más validaciones para facilitar la internacionalidad de la aplicación
    private string $value;

    private function __construct(string $value)
    {
        $trimmed = trim($value);
        if ($trimmed === '') {
            throw new \InvalidArgumentException('You must especify a tax ID cannot be empty.');
        }

        $this->value = $trimmed;
    }

    public static function create(string $value): self
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}