<?php

namespace App\User\Infrastructure\Entrypoint\Http;

use App\User\Application\GetAllUsers\GetAllUsers;
use Illuminate\Http\JsonResponse;

class GetAllController
{
    public function __construct(
        private GetAllUsers $getAllUsers,
    )
    {}

    public function __invoke(): JsonResponse
    {
        $response = ($this->getAllUsers)();

        if($response == null) {
            return new JsonResponse('Users not found', 404);
        } else {
            return new JsonResponse($response->toArray(), 200);
        }
    }
}