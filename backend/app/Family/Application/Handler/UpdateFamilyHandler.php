<?php

namespace App\Family\Application\Handler;

use App\Family\Application\Command\UpdateFamilyCommand;
use App\Family\Domain\Services\FamilyExistsService;
use App\Family\Domain\Services\FindFamilyByIdService;
use App\Family\Domain\Services\UpdateFamilyservice;
use App\Shared\Domain\Exceptions\EntityNotFoundException;
use App\Shared\Domain\ValueObject\Name;

class UpdateFamilyHandler
{
    public function __construct(
        private UpdateFamilyservice $updateService,
        private FamilyExistsService $existsService,
        private FindFamilyByIdService $findService,
    ) {}

    public function __invoke(UpdateFamilyCommand $command): void
    {
        if ($this->existsService->execute($command->id(), $command->restaurantId()) === false) {
            throw new EntityNotFoundException;
        }

        $foundFamily = $this->findService->execute($command->id(), $command->restaurantId());

        if ($command->name() === null) {
            $name = $foundFamily->name();
        } else {
            $name = Name::create($command->name());
        }

        if ($command->active() === null) {
            $active = $foundFamily->active();
        } else {
            $active = $command->active();
        }

        $updatedFamily = $foundFamily->updateData($name, $active);
        $this->updateService->execute($updatedFamily);
    }
}
