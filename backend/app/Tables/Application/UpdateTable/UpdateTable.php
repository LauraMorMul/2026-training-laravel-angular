<?php

namespace App\Tables\Application\UpdateTable;

use App\Shared\Domain\ValueObject\Name;
use App\Tables\Domain\Interfaces\TableRepositoryInterface;

class UpdateTable
{
    public function __construct(
        private TableRepositoryInterface $tableRepository,
    )
    {}

    public function __invoke(string $uuid, ?string $name): ? UpdateTableResponse
    {
        $table = $this->tableRepository->findById($uuid);

        if($name === null) {
            $nameVO = $table->name();
        }else {
            $nameVO = Name::create($name);
        }

        $table = $table->updateData($nameVO);
        $this->tableRepository->save($table);

        return UpdateTableResponse::create($table);
    }
}