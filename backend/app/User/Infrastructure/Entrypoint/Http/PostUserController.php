<?php

namespace App\User\Infrastructure\Entrypoint\Http;

use App\User\Application\CreateUser\CreateUser;
use App\User\Domain\Exception\EmailInUseException;
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
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'max:40'],
            'image' => ['required', 'image', 'mimes:jpeg,jpg,png,gif,webp,avif,svg'],
            'pin' => ['required', 'string', 'digits_between:4,6'],

        ]);

        $restaurantId = auth('user')->user()->restaurant_id;

        if ($restaurantId === null) {
            return new JsonResponse('Unknown user', 403);
        }

        $imageContent = null;
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageContent = file_get_contents($image->getRealPath());
            $imageName = $image->hashName();
        }

        try {
            $response = ($this->createUser)(
                $imageContent,
                $imageName,
                $validated['email'],
                $validated['name'],
                $validated['password'],
                $validated['role'],
                $validated['pin'],
                $restaurantId,
            );
        } catch (EmailInUseException $e) {
            return new JsonResponse('Email in use.', 409);
        }

        return new JsonResponse($response->toArray(), 201);
    }
}
