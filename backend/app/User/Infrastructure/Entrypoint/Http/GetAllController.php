<?php

namespace App\User\Infrastructure\Entrypoint\Http;

use App\User\Application\GetAllUsers\GetAllUsers;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetAllController
{
    public function __construct(
        private GetAllUsers $getAllUsers,
    )
    {}

    public function __invoke(): JsonResponse
    {
        $response = ($this->getAllUsers)();
        
        return new JsonResponse($response->toArray(), 200);
    }
}