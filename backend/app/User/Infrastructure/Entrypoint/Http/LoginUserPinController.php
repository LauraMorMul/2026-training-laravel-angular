<?php

namespace App\User\Infrastructure\Entrypoint\Http;

use App\User\Application\LoginUserPin\LoginUserPin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginUserPinController
{
    public function __construct(
        private LoginUserPin $loginUser,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {

        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'pin' => ['required', 'string', 'min:4', 'max:4'],
        ]);

        $restaurantId = auth('restaurant')->user()->id;

        if ($restaurantId === null) {
            return new JsonResponse('Unknown user', 403);
        }

        $response = ($this->loginUser)(
            $validated['email'],
            $validated['pin'],
            $restaurantId,
        );

        return new JsonResponse($response->toArray(), 200);
    }
}
