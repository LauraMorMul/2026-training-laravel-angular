<?php

namespace App\Families\Application\UpdateFamily;

use App\Families\Domain\Interfaces\FamilyRepositoryInterface;
use App\Shared\Domain\ValueObject\Name;

class UpdateFamily
{
    public function __construct(
        private FamilyRepositoryInterface $familyRepository,
    )
    {}

    public function __invoke(string $uuid, ?string $name, ?bool $active): ? UpdateFamilyResponse
    {
        $family = $this->familyRepository->findById($uuid);

        if($name === null) {
            $nameVO = $family->name();
        }else {
            $nameVO = Name::create($name);
        }

        //Se denomina como VO para diferenciar el recibido por parámetro, pero es un booleano, no un VO
        if($active === null) {
            $activeVO = $family->active();
        }else {
            $activeVO = $active;
        }

        $family = $family->updateData($nameVO, $activeVO);
        $this->familyRepository->save($family);

        return UpdateFamilyResponse::create($family);
    }
}