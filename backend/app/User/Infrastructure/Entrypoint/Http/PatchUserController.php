<?php

namespace App\User\Infrastructure\Entrypoint\Http;

use App\User\Application\UpdateUser\UpdateUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatchUserController
{
    public function __construct(
        private UpdateUser $updateUser
    ) {}

    public function __invoke(string $id, Request $request): JsonResponse
    {
        $restaurantID = auth('user')->user()->restaurant_id;
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['nullable', 'string', 'max:40'],
            'image_src' => ['nullable', 'string'],
            'pin' => ['nullable', 'string', 'digits_between:4,6'],

        ]);

        $response = ($this->updateUser)(
            $id,
            $validated['email'] ?? null,
            $validated['name'] ?? null,
            $validated['password'] ?? null,
            $validated['role'] ?? null,
            $validated['image_src'] ?? null,
            $validated['pin'] ?? null,
            $restaurantID
        );

        if ($response === null) {
            return new JsonResponse('User not found.', 404);
        } else {
            return new JsonResponse($response->toArray(), 200);
        }
    }
}
