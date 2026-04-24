<?php

namespace App\Table\Infrastructure\Entrypoint\Http;

use App\Table\Application\GetTableByID\GetTableByID;
use Illuminate\Http\JsonResponse;

class GetTableByIDController
{
    public function __construct(
        private GetTableByID $getTableByID,
    ) {}

    public function __invoke(string $id)
    {
        $restaurantId = auth('user')->user()->restaurant_id;

        $response = ($this->getTableByID)($id, $restaurantId);
        if ($response == null) {
            return new JsonResponse('Table not found.', 404);
        } else {
            return new JsonResponse($response->toArray(), 200);
        }
    }
}
