<?php

namespace App\Family\Application\Command;

final readonly class DeleteFamilyCommand
{
    public function __construct(
        private string $id,
        private int $restaurantId,
    ) {}

    public function id()
    {
        return $this->id;
    }

    public function restaurantId()
    {
        return $this->restaurantId;
    }
}
