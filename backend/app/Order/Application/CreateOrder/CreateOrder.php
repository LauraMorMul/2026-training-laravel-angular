<?php

namespace App\Order\Application\CreateOrder;

use App\Order\Domain\Entity\Order;
use App\Order\Domain\Entity\OrderLine;
use App\Order\Domain\Interfaces\OrderLineRepositoryInterface;
use App\Order\Domain\Interfaces\OrderRepositoryInterface;
use App\Order\Domain\ValueObject\Diners;
use App\Order\Domain\ValueObject\OrderID;
use App\Order\Domain\ValueObject\ProductID;
use App\Order\Domain\ValueObject\Status;
use App\Order\Domain\ValueObject\TableID;
use App\Product\Domain\Interfaces\ProductRepositoryInterface;
use App\Shared\Domain\ValueObject\Price;
use App\Shared\Domain\ValueObject\Quantity;
use App\Shared\Domain\ValueObject\RestaurantID;
use App\Shared\Domain\ValueObject\UserID;
use App\Table\Domain\Interfaces\TableRepositoryInterface;
use App\Tax\Domain\ValueObject\Percentage;

class CreateOrder
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private OrderLineRepositoryInterface $orderLineRepository,
        private TableRepositoryInterface $tableRepository,
        private ProductRepositoryInterface $productRepository,
    ) {}

    public function __invoke(int $restaurantId, string $userId, string $tableUuid, int $diners, array $orderLines): string
    {
        $tableId = $this->tableRepository->findIdByUuid($tableUuid, $restaurantId);
        $restaurantIdVO = RestaurantID::create($restaurantId);
        $statusVO = Status::create('open');
        $tableIdVO = TableID::create($tableId);
        $dinersVO = Diners::create($diners);
        $openedByVO = UserID::create($userId);
        $order = Order::dddCreate($restaurantIdVO, $statusVO, $tableIdVO, $openedByVO, $dinersVO);
        $this->orderRepository->save($order);

        $orderId = $this->orderRepository->findIdByUuid($order->id()->value(), $restaurantId);
        $orderIdVo = OrderID::create($orderId);
        foreach ($orderLines as $orderLineValue) {
            $productId = $this->productRepository->findIdByUuid($orderLineValue['product_id']);
            $productVo = ProductID::create($productId);
            $quantityVo = Quantity::create($orderLineValue['quantity']);
            $priceVo = Price::create($orderLineValue['price']);
            $percentageVo = Percentage::create($orderLineValue['percentage']);
            $orderLine = OrderLine::dddCreate($restaurantIdVO, $orderIdVo, $productVo, $openedByVO, $quantityVo, $priceVo, $percentageVo);
            $this->orderLineRepository->save($orderLine);
        }

        return $order->id()->value();
    }
}
