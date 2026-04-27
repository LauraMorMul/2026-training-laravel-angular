<?php

namespace App\User\Infrastructure\Entrypoint\Http;

use App\User\Application\DeleteUserByID\DeleteUserByID;
use Illuminate\Http\JsonResponse;

class DeleteUserByIDController
{
    public function __construct(
        private DeleteUserByID $deleteUserByID,
    ) {}

    public function __invoke(string $id): JsonResponse
    {
        $restaurantId = auth('user')->user()->restaurant_id;
        $response = ($this->deleteUserByID)($id, $restaurantId);
        if ($response == true) {
            return new JsonResponse('User deleted correctly.', 200);
        } else {
            return new JsonResponse("User doesn't exist.", 500);
        }
    }
}
