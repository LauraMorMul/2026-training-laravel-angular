<?php

namespace App\User\Infrastructure\Entrypoint\Http;

use App\User\Application\LoginUser\LoginUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginUserController
{
    public function __construct(
        private LoginUser $loginUser,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {

        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $restaurantId = auth('restaurant')->user()->id;

        if ($restaurantId === null) {
            return new JsonResponse('Unknown user', 403);
        }

        $response = ($this->loginUser)(
            $validated['email'],
            $validated['password'],
            $restaurantId,
        );

        return new JsonResponse($response->toArray(), 200);
    }
}
