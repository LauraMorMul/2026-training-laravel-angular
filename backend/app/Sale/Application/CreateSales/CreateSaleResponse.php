<?php

namespace App\Sale\Application\CreateSales;

use App\Sale\Domain\Entity\Sale;

final readonly class CreateSaleResponse
{
    private function __construct(
        private string $id,
        private string $ticketNumber,
        private string $valueDate,
        private string $userClosesName
    ) {}

    public static function create(Sale $sale, string $userClosesName)
    {
        return new self(
            id: $sale->id()->value(),
            ticketNumber: $sale->ticketNumber()->value(),
            valueDate: $sale->valueDate()->format(\DateTimeInterface::ATOM),
            userClosesName: $userClosesName,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'ticket_number' => $this->ticketNumber,
            'value_date' => $this->valueDate,
            'user_closes_name' => $this->userClosesName,
        ];
    }
}
