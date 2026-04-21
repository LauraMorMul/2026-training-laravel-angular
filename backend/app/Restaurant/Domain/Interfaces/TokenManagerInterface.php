<?php

namespace App\Restaurant\Domain\Interfaces;

use App\Restaurant\Domain\Entity\Restaurant;

interface TokenManagerInterface
{
    public function issueToken(Restaurant $restaurant): string;

    public function removeTokens(Restaurant $restaurant): void;
}
