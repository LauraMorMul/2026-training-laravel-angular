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
            'role' => ['required', 'string', 'max:40'],
            'image' => ['required', 'image'],
            'pin' => ['required', 'string', 'digits_between:4,6'],

        ]);

        $restaurantId = auth('user')->user()->restaurant_id;

        if ($restaurantId === null) {
            return new JsonResponse('Unknown user', 403);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('users', 'public');
        }

        $response = ($this->createUser)(
            $validated['email'],
            $validated['name'],
            $validated['password'],
            $validated['role'],
            $imagePath,
            $validated['pin'],
            $restaurantId,
        );

        return new JsonResponse($response->toArray(), 201);
    }
}
