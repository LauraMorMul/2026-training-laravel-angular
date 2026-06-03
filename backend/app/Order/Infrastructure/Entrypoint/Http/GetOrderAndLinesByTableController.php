<?php

namespace App\Order\Infrastructure\Entrypoint\Http;

use App\Order\Application\GetOrderWithLinesByTable\GetOrderWithLinesByTable;
use Illuminate\Http\JsonResponse;

class GetOrderAndLinesByTableController
{
    public function __construct(
        private GetOrderWithLinesByTable $getOrderAndLines
    ) {}

    public function __invoke(string $tableUuid)
    {
        $restaurantId = auth('user')->user()->restaurant_id;
        $response = ($this->getOrderAndLines)($tableUuid, $restaurantId);
        if ($response == null) {
            return new JsonResponse('Order not found', 404);
        } else {
            return new JsonResponse($response->toArray(), 200);
        }
    }
}
