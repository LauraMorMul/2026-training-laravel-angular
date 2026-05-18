<?php

namespace App\Family\Application\Handler;

use App\Family\Application\Query\GetFamilyByIdQuery;
use App\Family\Application\Response\GetFamilyByIdResponse;
use App\Family\Domain\Services\FamilyExistsService;
use App\Family\Domain\Services\FindFamilyByIdService;
use App\Shared\Domain\Exceptions\EntityNotFoundException;

class GetFamilyByIdHandler
{
    public function __construct(
        private FindFamilyByIdService $findService,
        private FamilyExistsService $existsService,
    ) {}

    public function __invoke(GetFamilyByIdQuery $query): GetFamilyByIdResponse
    {
        if ($this->existsService->execute($query->id(), $query->restaurantId()) === false) {
            throw new EntityNotFoundException;
        }

        $family = $this->findService->execute($query->id(), $query->restaurantId());

        return GetFamilyByIdResponse::create($family);
    }
}
