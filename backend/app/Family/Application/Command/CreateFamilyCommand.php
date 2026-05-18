<?php

namespace App\Family\Application\Command;

final readonly class CreateFamilyCommand
{
    public function __construct(
        private string $name,
        private bool $active,
        private int $restaurantId
    ) {}

    public function name(): string
    {
        return $this->name;
    }

    public function active(): bool
    {
        return $this->active;
    }

    public function restaurantId(): int
    {
        return $this->restaurantId;
    }
}
