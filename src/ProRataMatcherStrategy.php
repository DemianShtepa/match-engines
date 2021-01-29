<?php

declare(strict_types=1);

namespace App;

use DateTimeImmutable;

final class ProRataMatcherStrategy extends MatcherStrategy
{
    public function match(): void
    {
        foreach ($this->buyOrderCollection->getOrders() as $buyOrder) {
            $sellOrders = $this->sellOrderCollection->getAllForOrder($buyOrder);
            if (count($sellOrders) > 0) {
                $totalQuantity = $this->getTotalQuantity($sellOrders);
                $quantityValue = floor(($buyOrder->getQuantity() / $totalQuantity) * 100);
                if ($quantityValue >= 100) {
                    $this->directMatch($buyOrder, $sellOrders);
                } else {
                    foreach ($sellOrders as $sellOrder) {
                        $resultQuantity = (int)floor(($quantityValue * $sellOrder->getQuantity()) / 100);
                        $sellOrder->setQuantity($resultQuantity);
                        $buyOrder->setQuantity($buyOrder->getQuantity() - $sellOrder->getQuantity());

                        $this->orderPairs[] = new OrderPair($buyOrder, $sellOrder, $sellOrder->getPrice(), $sellOrder->getQuantity(), new DateTimeImmutable());
                    }
                    if ($buyOrder->getQuantity() > 0) {
                        $this->directMatch($buyOrder, $this->sortSellOrders($sellOrders));
                    }
                }
            }
        }
    }

    private function getTotalQuantity(array $sellOrders): float
    {
        return array_reduce($sellOrders, function (float $carry, Order $order) {
            return $carry + $order->getQuantity();
        }, 0);
    }

    /**
     * @return Order[]
     */
    private function sortSellOrders(array $sellOrders): array
    {
        usort($sellOrders, function (Order $order1, Order $order2) {
            if (($comparedPrice = $order1->getPrice() <=> $order2->getPrice()) !== 0) {
                return $comparedPrice;
            }

            return $order1->getCreatedAt() <=> $order2->getCreatedAt();
        });

        return $sellOrders;
    }
}