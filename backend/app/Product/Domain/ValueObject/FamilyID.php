<?php

namespace App\Product\Domain\ValueObject;

class FamilyID
{
    private int $value;

    private function __construct(int $value)
    {
        $trimmed = trim($value);
        if ($trimmed === '') {
            throw new \InvalidArgumentException('Family ID is mandatory.');
        }
        if (! ctype_digit($trimmed)) {
            throw new \InvalidArgumentException('Remember, it uses the internal ID.');
        }

        $this->value = $trimmed;
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
