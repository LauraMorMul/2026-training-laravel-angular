<?php

namespace App\Family\Application\UpdateFamily;

use App\Family\Domain\Interfaces\FamilyRepositoryInterface;
use App\Shared\Domain\ValueObject\Name;

class UpdateFamily
{
    public function __construct(
        private FamilyRepositoryInterface $familyRepository,
    ) {}

    public function __invoke(string $uuid, ?string $name, ?bool $active): ?UpdateFamilyResponse
    {
        $family = $this->familyRepository->findById($uuid);

        if ($name === null) {
            $nameVO = $family->name();
        } else {
            $nameVO = Name::create($name);
        }

        if ($active === null) {
            $isActive = $family->active();
        } else {
            $isActive = $active;
        }

        $family = $family->updateData($nameVO, $isActive);
        $this->familyRepository->save($family);

        return UpdateFamilyResponse::create($family);
    }
}
