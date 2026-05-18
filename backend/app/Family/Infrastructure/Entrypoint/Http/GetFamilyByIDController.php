<?php

namespace App\Family\Infrastructure\Entrypoint\Http;

use App\Family\Application\Handler\GetFamilyByIdHandler;
use App\Family\Application\Query\GetFamilyByIdQuery;
use App\Shared\Domain\Exceptions\EntityNotFoundException;
use Exception;
use Illuminate\Http\JsonResponse;

class GetFamilyByIDController
{
    public function __construct(
        private GetFamilyByIdHandler $getHandler,
    ) {}

    public function __invoke(string $id)
    {
        $restaurantId = auth('user')->user()->restaurant_id;

        try {
            $query = new GetFamilyByIdQuery($restaurantId, $id);
            $response = ($this->getHandler)($query);
        } catch (EntityNotFoundException) {
            return new JsonResponse('Family not found.', 404);
        } catch (Exception) {
            return new JsonResponse('Something went wrong.', 500);
        }

        return new JsonResponse($response->toArray(), 200);
    }
}
