<?php

declare(strict_types=1);

namespace App;

use DateTimeImmutable;

final class OrderPair
{
    private Order $buyOrder;
    private Order $sellOrder;
    private int $quantity;
    private float $price;
    private DateTimeImmutable $createdAt;

    public function __construct(Order $buyOrder, Order $sellOrder, float $price, int $quantity, DateTimeImmutable $createdAt)
    {
        $this->buyOrder = $buyOrder;
        $this->sellOrder = $sellOrder;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->createdAt = $createdAt;
    }
}