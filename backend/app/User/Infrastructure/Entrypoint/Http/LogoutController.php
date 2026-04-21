<?php

namespace App\User\Infrastructure\Entrypoint\Http;

use App\User\Application\LogoutUser\LogoutUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController
{
    public function __construct(
        private LogoutUser $logOut
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $response = ($this->logOut)(auth()->user());

        return new JsonResponse('Log out complete', 200);
    }
}
