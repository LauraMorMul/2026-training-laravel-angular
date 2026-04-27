<?php

namespace App\User\Infrastructure\Entrypoint\Http;

use App\User\Application\LogoutUser\LogoutUser;
use Illuminate\Http\JsonResponse;

class LogoutController
{
    public function __construct(
        private LogoutUser $logOut
    ) {}

    public function __invoke(): JsonResponse
    {

        $response = ($this->logOut)();

        return new JsonResponse('Log out complete', 200);
    }
}
