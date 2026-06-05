<?php

namespace App\Sale\Domain\ValueObject;

class TicketNumber
{
    private const PATTERN = '/T-[0-9]+/m';

    private string $value;

    private function __construct(string $value)
    {
        if (! preg_match(self::PATTERN, $value)) {
            throw new \InvalidArgumentException("Invalid ticket number: $value");
        }

        $this->value = $value;
    }

    public static function create(string $value): self
    {
        return new self($value);
    }

    public static function generate(int $lastTicket): self
    {
        $ticket = 'T-'.$lastTicket + 1;

        return self::create($ticket);
    }

    public function value(): string
    {
        return $this->value;
    }
}
