<?php

namespace App\Family\Application\Query;

final class GetFamiliesQuery
{
    public function __construct(
        private int $restaurantId,
    ) {}

    public function restaurantId(): int
    {
        return $this->restaurantId;
    }
}
