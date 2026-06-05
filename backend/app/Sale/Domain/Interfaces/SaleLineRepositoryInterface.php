<?php

namespace App\Sale\Domain\Interfaces;

use App\Sale\Domain\Entity\SaleLine;

interface SaleLineRepositoryInterface
{
    public function save(SaleLine $saleLine): void;
}
