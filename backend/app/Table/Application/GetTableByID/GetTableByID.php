<?php

namespace App\Table\Application\GetTableByID;

use App\Table\Domain\Interfaces\TableRepositoryInterface;

class GetTableByID
{
    public function __construct(
        private TableRepositoryInterface $tableRepository
    ) {}

    public function __invoke(string $id): ?GetTableByIDResponse
    {
        $table = $this->tableRepository->findByID($id);

        if ($table == null) {
            return null;
        } else {
            return GetTableByIDResponse::create($table);
        }
    }
}
