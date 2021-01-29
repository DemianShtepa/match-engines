<?php

declare(strict_types=1);

namespace App;

abstract class OrderCollection
{
    /** @var Order[] */
    protected array $collection;

    public function __construct()
    {
        $this->collection = [];
    }

    public function addOrder(Order $order): void
    {
        $this->collection[$order->getId()] = $order;
    }

    public function removeOrder(Order $order): void
    {
        unset($this->collection[$order->getId()]);
    }
}