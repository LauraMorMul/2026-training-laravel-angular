<?php

namespace App\User\Infrastructure\Entrypoint\Http;

use App\User\Application\RemoveTokens\RemoveTokens;
use Illuminate\Http\JsonResponse;

class RemoveTokensController
{
    public function __construct(
        public RemoveTokens $removeTokens,
    ) {}

    public function __invoke()
    {
        $response = ($this->removeTokens)();

        return new JsonResponse('Token delete complete', 200);
    }
}
