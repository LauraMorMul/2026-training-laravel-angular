<?php

namespace App\Family\Infrastructure\Entrypoint\Http;

use App\Family\Application\Handler\GetFamiliesHandler;
use App\Family\Application\Query\GetFamiliesQuery;
use Exception;
use Illuminate\Http\JsonResponse;

class GetFamiliesController
{
    public function __construct(
        private GetFamiliesHandler $getHandler
    ) {}

    public function __invoke()
    {
        $restaurantId = auth('user')->user()->restaurant_id;

        try {
            $query = new GetFamiliesQuery($restaurantId);
            $response = ($this->getHandler)($query);
        } catch (Exception) {
            return new JsonResponse('Something went wrong', 500);
        }

        return new JsonResponse($response->toArray(), 200);
    }
}
