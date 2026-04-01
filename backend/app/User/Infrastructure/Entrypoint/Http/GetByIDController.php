<?php

namespace App\User\Infrastructure\Entrypoint\Http;

use App\User\Application\GetUserByID\GetUserByID;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetByIDController
{
    public function __construct(
        private GetUserByID $getUserByID
    )
    {}

    public function __invoke(string $id)
    {
        $response = ($this->getUserByID)($id);

        return new JsonResponse($response->toArray(), 200);
    }
}