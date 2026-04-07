<?php

namespace App\Families\Application\CreateFamily;

use App\User\Domain\Entity\Family;
use App\User\Domain\ValueObject\Name;

class CreateFamily
{
    public function __construct(
        private FamilyRepositoryInterface $familyRepository,
    ){}

    public function __invoke(string $name, bool $active): CreateFamilyResponse
    {
        $nameVO = Name::create($name);
        $family = Family::dddCreate($nameVO, $active);
        $this->familyRepository->save($family);

        return CreateFamilyResponse::create($family);
    }
}