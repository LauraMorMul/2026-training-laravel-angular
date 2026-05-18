<?php

namespace App\Shared\Infrastructure\Services;

use App\Shared\Domain\Interfaces\TransactionManagerInterface;
use Illuminate\Support\Facades\DB;
use Override;

class LaravelTransactionManager implements TransactionManagerInterface
{
    #[Override]
    public function execute(callable $callback): void
    {
        DB::transaction($callback);
    }
}
