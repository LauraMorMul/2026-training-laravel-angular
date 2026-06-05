<?php

namespace App\Sale\Infrastructure\Entrypoint\Http;

use App\Sale\Application\CreateSales\CreateSale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostSaleController
{
    public function __construct(
        private CreateSale $createSale
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $restaurantId = auth('user')->user()->restaurant_id;
        $userId = auth('user')->user()->id;

        $validated = $request->validate([
            'order_id' => ['required', 'string', 'exists:orders,uuid'],
            'total' => ['required'],
        ]);

        $response = ($this->createSale)(
            $restaurantId,
            $validated['order_id'],
            $userId,
            $validated['total']
        );

        return new JsonResponse($response->toArray(), 201);
    }
}
