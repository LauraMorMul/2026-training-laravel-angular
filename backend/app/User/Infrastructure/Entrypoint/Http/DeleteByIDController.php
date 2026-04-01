<?php

namespace App\User\Infrastructure\Entrypoint\Http;

use App\User\Application\DeleteUserByID\DeleteUserByID;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteByIDController
{
    public function __construct(
        private DeleteUserByID $deleteUserByID,
    ) {}

    public function __invoke(string $id): JsonResponse
    {
        $response = ($this->deleteUserByID)($id);
        if($response == null) {
            return new JsonResponse('User not deleted.', 200);
        } else {
            return new JsonResponse($response, 204);
        }
    }
}