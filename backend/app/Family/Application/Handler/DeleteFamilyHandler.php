<?php

namespace App\Family\Application\Handler;

use App\Family\Application\Command\DeleteFamilyCommand;
use App\Family\Domain\Exceptions\FamilyHasProductsException;
use App\Family\Domain\Services\DeleteFamilyService;
use App\Family\Domain\Services\FamilyExistsService;
use App\Family\Domain\Services\FamilyHasProductsService;
use App\Shared\Domain\Exceptions\EntityNotFoundException;

class DeleteFamilyHandler
{
    public function __construct(
        public DeleteFamilyService $deleteService,
        public FamilyExistsService $existsService,
        public FamilyHasProductsService $hasProductsService,
    ) {}

    public function __invoke(DeleteFamilyCommand $command)
    {
        if ($this->existsService->execute($command->id(), $command->restaurantId()) === false) {
            throw new EntityNotFoundException;
        }
        if ($this->hasProductsService->execute($command->id(), $command->restaurantId()) === true) {
            throw new FamilyHasProductsException;
        }

        $this->deleteService->execute($command->id(), $command->restaurantId());
    }
}
