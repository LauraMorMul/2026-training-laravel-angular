<?php

namespace App\Family\Application\Handler;

use App\Family\Application\Command\CreateFamilyCommand;
use App\Family\Domain\Entity\Family;
use App\Family\Domain\Services\CreateFamilyService;
use App\Shared\Domain\ValueObject\Name;
use App\Shared\Domain\ValueObject\RestaurantID;

class CreateFamilyHandler
{
    public function __construct(
        private CreateFamilyService $createService,
    ) {}

    public function __invoke(CreateFamilyCommand $command): void
    {
        $restaurantIDVO = RestaurantID::create($command->restaurantId());
        $nameVO = Name::create($command->name());
        $family = Family::dddCreate($restaurantIDVO, $nameVO, $command->active());

        $this->createService->execute($family);
    }
}
