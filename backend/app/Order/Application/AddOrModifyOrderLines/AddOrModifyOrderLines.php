<?php

namespace App\Order\Application\AddOrModifyOrderLines;

use App\Order\Domain\Entity\OrderLine;
use App\Order\Domain\Interfaces\OrderLineRepositoryInterface;
use App\Order\Domain\Interfaces\OrderRepositoryInterface;
use App\Order\Domain\ValueObject\OrderID;
use App\Order\Domain\ValueObject\ProductID;
use App\Product\Domain\Interfaces\ProductRepositoryInterface;
use App\Shared\Domain\ValueObject\Price;
use App\Shared\Domain\ValueObject\Quantity;
use App\Shared\Domain\ValueObject\RestaurantID;
use App\Shared\Domain\ValueObject\UserID;
use App\Tax\Domain\ValueObject\Percentage;

class AddOrModifyOrderLines
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private OrderLineRepositoryInterface $orderLineRepository,
        private ProductRepositoryInterface $productRepository
    ) {}

    public function __invoke(int $restaurantId, string $orderUuid, array $orderLines, int $userId)
    {
        foreach ($orderLines as $orderLineSent) {
            $foundOrderLine = $this->orderLineRepository->findByOrderAndProduct($orderUuid, $orderLineSent['product_id'], $restaurantId);
            if ($foundOrderLine !== null) {
                $orderLineEntity = OrderLine::fromPersistence(
                    $foundOrderLine->uuid,
                    $foundOrderLine->restaurant_id,
                    $foundOrderLine->order_id,
                    $foundOrderLine->product_id,
                    $foundOrderLine->user_id,
                    $foundOrderLine->quantity,
                    $foundOrderLine->price,
                    $foundOrderLine->tax_percentage,
                    new \DateTimeImmutable($foundOrderLine->created_at),
                    new \DateTimeImmutable($foundOrderLine->updated_at)
                );

                $updatedLine = $orderLineEntity->updateData(
                    Quantity::create($orderLineSent['quantity']),
                    Price::create($orderLineSent['price'])
                );

                $this->orderLineRepository->save($updatedLine);
            } else {
                $orderId = $this->orderRepository->findIdByUuid($orderUuid, $restaurantId);
                $restaurantIdVO = RestaurantID::create($restaurantId);
                $orderIdVo = OrderID::create($orderId);
                $userIdVo = UserID::create($userId);
                $productId = $this->productRepository->findIdByUuid($orderLineSent['product_id']);
                $productVo = ProductID::create($productId);
                $quantityVo = Quantity::create($orderLineSent['quantity']);
                $priceVo = Price::create($orderLineSent['price']);
                $percentageVo = Percentage::create($orderLineSent['percentage']);
                $orderLine = OrderLine::dddCreate($restaurantIdVO, $orderIdVo, $productVo, $userIdVo, $quantityVo, $priceVo, $percentageVo);
                $this->orderLineRepository->save($orderLine);
            }
        }
    }
}
