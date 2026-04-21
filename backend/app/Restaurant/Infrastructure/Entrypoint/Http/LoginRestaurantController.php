<?php

namespace App\Restaurant\Infrastructure\Entrypoint\Http;

use App\Restaurant\Application\LoginRestaurant\LoginRestaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginRestaurantController
{
    public function __construct(
        private LoginRestaurant $loginRestaurant,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $response = ($this->loginRestaurant)(
            $validated['email'],
            $validated['password'],
        );

        return new JsonResponse($response->toArray(), 200);
    }
}
