<?php

namespace App\Tables\Infrastructure\Entrypoint\Http;

use App\Tables\Application\GetTableByID\GetTableByID;
use Illuminate\Http\JsonResponse;

class GetTableByIDController
{
    public function __construct(
        private GetTableByID $getTableByID,
    )
    {}

    public function __invoke(string $id)
    {
        $response = ($this->getTableByID)($id);
        if($response == null) {
            return new JsonResponse('Table not found', 404);
        } else {
            return new JsonResponse($response->toArray(), 200);
        }
    }
}