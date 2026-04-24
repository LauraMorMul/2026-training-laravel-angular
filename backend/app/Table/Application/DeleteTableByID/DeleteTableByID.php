<?php

namespace App\Table\Application\DeleteTableByID;

use App\Table\Domain\Interfaces\TableRepositoryInterface;

class DeleteTableByID
{
    public function __construct(
        private TableRepositoryInterface $tableRepository,
    ) {}

    public function __invoke(string $id, int $restaurantID): bool
    {
        $exists = $this->tableRepository->findById($id);
        if ($exists === null || $exists->restaurantID()->value() !== $restaurantID) {
            return false;
        } else {
            $deleted = $this->tableRepository->deleteByID($id);

            return true;
        }
    }
}
