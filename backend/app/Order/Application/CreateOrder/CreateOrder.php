<?php

namespace App\Order\Application\CreateOrder;

use App\Order\Domain\Entity\Order;
use App\Order\Domain\Interfaces\OrderLineRepositoryInterface;
use App\Order\Domain\Interfaces\OrderRepositoryInterface;
use App\Order\Domain\ValueObject\Diners;
use App\Order\Domain\ValueObject\Status;
use App\Order\Domain\ValueObject\TableID;
use App\Shared\Domain\ValueObject\RestaurantID;
use App\Shared\Domain\ValueObject\UserID;
use App\Table\Domain\Interfaces\TableRepositoryInterface;
use App\User\Domain\Interfaces\UserRepositoryInterface;

class CreateOrder
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private OrderLineRepositoryInterface $orderLineRepository,
        private TableRepositoryInterface $tableRepository,
        private UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(int $restaurantId, string $userUuid, string $tableUuid, int $diners, array $orderLines)
    {
        $tableId = $this->tableRepository->findIdByUuid($tableUuid, $restaurantId);
        $userId = $this->userRepository->findIdByUuid($userUuid, $restaurantId);
        // primero guardo el pedido, luego busco el id del pedido en base al uuid, y luego le meto ese id a cada línea
        $restaurantIdVO = RestaurantID::create($restaurantId);
        $statusVO = Status::create('open');
        $tableIdVO = TableID::create($tableId);
        $dinersVO = Diners::create($diners);
        $openedByVO = UserID::create($userId);
        $order = Order::dddCreate($restaurantIdVO, $statusVO, $tableIdVO, $openedByVO, $dinersVO);
        $this->orderRepository->save($order);

    }
}
