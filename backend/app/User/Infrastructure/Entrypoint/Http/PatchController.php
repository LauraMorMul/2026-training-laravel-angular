<?php

namespace App\User\Infrastructure\Entrypoint\Http;

use App\User\Application\UpdateUser\UpdateUser;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PatchController
{
    public function __construct(
        private UpdateUser $updateUser
    ) {}

    public function __invoke(string $id, Request $request): JsonResponse
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

        $response = ($this->updateUser)(
            $id,
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