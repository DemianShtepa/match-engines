<?php

declare(strict_types=1);

namespace App;

use DateTimeImmutable;

final class PriceTimeMatcherStrategy extends MatcherStrategy
{
    public function match(): void
    {
        foreach ($this->buyOrderCollection->getOrders() as $buyOrder) {
            $sellOrders = $this->sellOrderCollection->getPriorityForOrder($buyOrder);
            $this->directMatch($buyOrder, $sellOrders);
        }
    }
}