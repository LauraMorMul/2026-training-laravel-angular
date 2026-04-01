<?php

namespace App\User\Infrastructure\Entrypoint\Http;

use App\User\Application\GetUserByID\GetUserByID;
use Illuminate\Http\JsonResponse;

class GetByIDController
{
    public function __construct(
        private GetUserByID $getUserByID
    )
    {}

    public function __invoke(string $id)
    {
        $response = ($this->getUserByID)($id);
        if($response == null) {
            return new JsonResponse('User not found', 404);
        } else {
            return new JsonResponse($response->toArray(), 200);
        }
        
    }
}