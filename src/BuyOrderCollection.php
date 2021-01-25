<?php

declare(strict_types=1);

namespace App;

final class BuyOrderCollection extends OrderCollection
{
    /**
     * @return Order[]
     */
    public function getOrders(): array
    {
        return $this->collection;
    }
}