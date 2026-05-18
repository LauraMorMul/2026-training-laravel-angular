<?php

namespace App\Shared\Domain\Interfaces;

interface TransactionManagerInterface
{
    public function execute(callable $callback): void;
}
