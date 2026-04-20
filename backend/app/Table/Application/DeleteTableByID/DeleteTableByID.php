<?php

namespace App\Table\Application\DeleteTableByID;

use App\Table\Domain\Interfaces\TableRepositoryInterface;

class DeleteTableByID
{
    public function __construct(
        private TableRepositoryInterface $tableRepository,
    ) {}

    public function __invoke(string $id): void
    {
        $deleted = $this->tableRepository->deleteByID($id);
    }
}
