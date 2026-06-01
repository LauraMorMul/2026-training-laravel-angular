<?php

namespace App\Order\Infrastructure\Entrypoint\Http;

use App\Order\Application\AddOrModifyOrderLines\AddOrModifyOrderLines;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatchOrPostOrderLinesController
{
    public function __construct(
        private AddOrModifyOrderLines $orderLinesManager
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $restaurantId = auth('user')->user()->restaurant_id;
        $userId = auth('user')->user()->id;

        $validated = $request->validate([
            'order_id' => ['required', 'string', 'exists:orders,uuid'],
            'orderLines' => ['array'],
            'orderLines.*.product_id' => ['required', 'string', 'exists:products,uuid'],
            'orderLines.*.quantity' => ['required', 'integer', 'min:1'],
            'orderLines.*.price' => ['required', 'integer', 'min:0'],
            'orderLines.*.percentage' => ['required', 'integer', 'min:0'],
        ]);

        ($this->orderLinesManager)(
            $restaurantId,
            $validated['order_id'],
            $validated['orderLines'],
            $userId
        );

        return new JsonResponse('To fancy', 200);
    }
}
