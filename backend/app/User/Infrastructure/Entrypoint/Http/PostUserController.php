<?php

namespace App\User\Infrastructure\Entrypoint\Http;

use App\User\Application\CreateUser\CreateUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostUserController
{
    public function __construct(
        private CreateUser $createUser,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'restaurant_id' => ['required', 'integer', 'exists:restaurants,id' ],
            'role' => ['required', 'string', 'max:40'],
            'image_src' => ['required', 'string'],
            'pin' => ['required', 'string', 'digits_between:4,6'],

        ]);

        $response = ($this->createUser)(
            $validated['email'],
            $validated['name'],
            $validated['password'],
            $validated['restaurant_id'],
            $validated['role'],
            $validated['image_src'],
            $validated['pin'],
        );

        return new JsonResponse($response->toArray(), 201);
    }
}
