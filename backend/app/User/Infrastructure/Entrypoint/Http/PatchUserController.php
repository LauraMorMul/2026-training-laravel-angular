<?php

namespace App\User\Infrastructure\Entrypoint\Http;

use App\User\Application\UpdateUser\UpdateUser;
use App\User\Domain\Exception\EmailInUseException;
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
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['nullable', 'string', 'max:40'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp,avif,svg'],
            'pin' => ['nullable', 'string', 'digits_between:4,6'],

        ]);

        $imageContent = null;
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageContent = file_get_contents($image->getRealPath());
            $imageName = $image->hashName();
        }

        try {
            $response = ($this->updateUser)(
                $id,
                $imageContent,
                $imageName,
                $validated['email'] ?? null,
                $validated['name'] ?? null,
                $validated['password'] ?? null,
                $validated['role'] ?? null,
                $validated['pin'] ?? null,
                $restaurantID
            );
        } catch (EmailInUseException $e) {
            return new JsonResponse('Email already in use.', 422);
        }

        if ($response === null) {
            return new JsonResponse('User not found.', 404);
        } else {
            return new JsonResponse($response->toArray(), 200);
        }
    }
}
