<?php

declare(strict_types=1);

namespace App;

use DateTimeImmutable;

abstract class MatcherStrategy
{
    protected BuyOrderCollection $buyOrderCollection;
    protected SellOrderCollection $sellOrderCollection;
    /** @var OrderPair[] */
    protected array $orderPairs;

    public function __construct(BuyOrderCollection $buyOrderCollection, SellOrderCollection $sellOrderCollection)
    {
        $this->buyOrderCollection = $buyOrderCollection;
        $this->sellOrderCollection = $sellOrderCollection;
        $this->orderPairs = [];
    }

    protected function directMatch(Order $buyOrder, array $sellOrders): void
    {
        foreach ($sellOrders as $sellOrder) {
            $quantityDiff = $buyOrder->getQuantity() - $sellOrder->getQuantity();

            if ($quantityDiff > 0) {
                $this->sellOrderCollection->removeOrder($buyOrder);

                $this->orderPairs[] = new OrderPair($buyOrder, $sellOrder, $sellOrder->getPrice(), $sellOrder->getQuantity(), new DateTimeImmutable());

                $buyOrder->setQuantity($quantityDiff);
            } elseif ($quantityDiff === 0) {
                $this->sellOrderCollection->removeOrder($sellOrder);
                $this->buyOrderCollection->removeOrder($buyOrder);

                $this->orderPairs[] = new OrderPair($buyOrder, $sellOrder, $sellOrder->getPrice(), $sellOrder->getQuantity(), new DateTimeImmutable());

                break;
            } else {
                $this->buyOrderCollection->removeOrder($buyOrder);

                $this->orderPairs[] = new OrderPair($buyOrder, $sellOrder, $sellOrder->getPrice(), $buyOrder->getQuantity(), new DateTimeImmutable());

                $sellOrder->setQuantity(-$quantityDiff);
                break;
            }
        }
    }

    public abstract function match(): void;

    public function getOrderPairs(): array
    {
        return $this->orderPairs;
    }
}