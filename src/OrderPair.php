<?php

declare(strict_types=1);

namespace App;

use DateTimeImmutable;

final class OrderPair
{
    private Order $buyOrder;
    private Order $sellOrder;
    private int $quantity;
    private DateTimeImmutable $createdAt;

    public function __construct(Order $buyOrder, Order $sellOrder, int $quantity, DateTimeImmutable $createdAt)
    {
        $this->buyOrder = $buyOrder;
        $this->sellOrder = $sellOrder;
        $this->quantity = $quantity;
        $this->createdAt = $createdAt;
    }
}