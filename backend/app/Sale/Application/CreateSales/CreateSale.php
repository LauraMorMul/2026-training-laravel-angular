<?php

namespace App\Sale\Application\CreateSales;

use App\Order\Domain\Interfaces\OrderLineRepositoryInterface;
use App\Order\Domain\Interfaces\OrderRepositoryInterface;
use App\Order\Domain\ValueObject\OrderID;
use App\Sale\Domain\Entity\Sale;
use App\Sale\Domain\Entity\SaleLine;
use App\Sale\Domain\Interfaces\SaleLineRepositoryInterface;
use App\Sale\Domain\Interfaces\SaleRepositoryInterface;
use App\Sale\Domain\ValueObject\OrderLineID;
use App\Sale\Domain\ValueObject\SaleID;
use App\Sale\Domain\ValueObject\TicketNumber;
use App\Shared\Domain\ValueObject\DomainDateTime;
use App\Shared\Domain\ValueObject\Price;
use App\Shared\Domain\ValueObject\Quantity;
use App\Shared\Domain\ValueObject\RestaurantID;
use App\Shared\Domain\ValueObject\UserID;
use App\Tax\Domain\ValueObject\Percentage;
use App\User\Domain\Interfaces\UserRepositoryInterface;

class CreateSale
{
    public function __construct(
        private SaleRepositoryInterface $saleRepository,
        private SaleLineRepositoryInterface $saleLineRepository,
        private OrderRepositoryInterface $orderRepository,
        private OrderLineRepositoryInterface $orderLineRepository,
        private UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(int $restaurantId, string $orderUuid, string $userId, int $total)
    {
        $currentYear = (int) date('Y');
        $lastTicket = $this->saleRepository->getLastTicketNumber($restaurantId, $currentYear);
        $restaurantIdVO = RestaurantID::create($restaurantId);
        $orderId = $this->orderRepository->findIdByUuid($orderUuid, $restaurantId);
        $orderIdVO = OrderID::create($orderId);
        $userOrderIdVO = UserID::create($userId);
        $ticketNumberVO = TicketNumber::generate($lastTicket);
        $valueDate = DomainDateTime::now();
        $totalVO = Price::create($total);
        $sale = Sale::dddCreate($restaurantIdVO, $orderIdVO, $userOrderIdVO, $ticketNumberVO, $valueDate, $totalVO);
        $this->saleRepository->save($sale);

        $saleId = $this->saleRepository->findIdByUuid($sale->id()->value(), $restaurantId);
        $saleIdVo = SaleID::create($saleId);

        $orderLines = $this->orderLineRepository->getByOrder($orderUuid, $restaurantId);

        foreach ($orderLines as $orderLine) {
            $orderLineId = $this->orderLineRepository->findIdByUuid($orderLine->id()->value(), $restaurantId);
            $orderLineIdVO = OrderLineID::create($orderLineId);
            $userOrderLineIdVO = UserID::create($orderLine->userId()->value());
            $quantityVO = Quantity::create($orderLine->quantity()->value());
            $priceVO = Price::create($orderLine->price()->value());
            $taxPercentageVO = Percentage::create($orderLine->taxPercentage()->value());
            $saleLine = SaleLine::dddCreate($restaurantIdVO, $saleIdVo, $orderLineIdVO, $userOrderLineIdVO, $quantityVO, $priceVO, $taxPercentageVO);
            $this->saleLineRepository->save($saleLine);
        }
        $userClosesName = $this->userRepository->findByInternalId($userId)->name()->value();

        return CreateSaleResponse::create($sale, $userClosesName);
    }
}
