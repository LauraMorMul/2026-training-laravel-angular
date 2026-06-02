<?php

namespace App\Order\Infrastructure\Entrypoint\Http;

use App\Order\Application\CreateOrder\CreateOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostOrderWithLinesController
{
    public function __construct(
        private CreateOrder $createOrder
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $restaurantId = auth('user')->user()->restaurant_id;
        $userId = auth('user')->user()->id;

        $validated = $request->validate([
            'table_id' => ['required', 'string', 'exists:tables,uuid'],
            'diners' => ['required', 'integer', 'min:0'],
            'orderLines' => ['required', 'array', 'min:1'],
            'orderLines.*.product_id' => ['required', 'string', 'exists:products,uuid'],
            'orderLines.*.quantity' => ['required', 'integer', 'min:1'],
            'orderLines.*.price' => ['required', 'integer', 'min:0'],
            'orderLines.*.percentage' => ['required', 'integer', 'min:0'],
        ]);

        $response = ($this->createOrder)(
            $restaurantId,
            $userId,
            $validated['table_id'],
            $validated['diners'],
            $validated['orderLines'],
        );

        return new JsonResponse($response->toArray(), 201);
    }
}
