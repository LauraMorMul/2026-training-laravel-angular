<?php

namespace App\Order\Domain\ValueObject;

use App\Product\Domain\Exceptions\UnacceptedStatusException;

class Status
{
    private ?string $value;

    private const ACCEPTED_STATES = ['open', 'cancelled', 'invoiced'];

    private function __construct(string $value)
    {
        if ($value === null || trim($value) === '') {
            $this->value = null;

            return;
        }
        $trimmed = trim($value);

        if (! in_array($trimmed, self::ACCEPTED_STATES)) {
            throw new UnacceptedStatusException;
        }

        $this->value = $trimmed;
    }

    public static function create(string $value): self
    {
        return new self($value);
    }

    public function value(): ?string
    {
        return $this->value;
    }
}
