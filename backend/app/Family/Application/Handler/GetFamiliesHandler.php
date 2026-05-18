<?php

namespace App\Family\Application\Handler;

use App\Family\Application\Query\GetFamiliesQuery;
use App\Family\Application\Response\GetFamiliesResponse;
use App\Family\Domain\Services\GetFamiliesService;

class GetFamiliesHandler
{
    public function __construct(
        private GetFamiliesService $familyService
    ) {}

    public function __invoke(GetFamiliesQuery $query): GetFamiliesResponse
    {
        $families = $this->familyService->execute($query->restaurantId());

        return GetFamiliesResponse::create($families);
    }
}
