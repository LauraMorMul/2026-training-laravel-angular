<?php

namespace App\Family\Application\Query;

final class GetFamilyByIdQuery
{
    public function __construct(
        private int $restaurantId,
        private string $id
    ) {}

    public function restaurantId(): int
    {
        return $this->restaurantId;
    }

    public function id(): string
    {
        return $this->id;
    }
}
