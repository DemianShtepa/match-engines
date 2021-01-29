<?php

declare(strict_types=1);

namespace App;

final class SellOrderCollection extends OrderCollection
{
    /**
     * @return Order[]
     */
    public function getPriorityForOrder(Order $buyOrder): array
    {
        $filteredOrders = array_filter($this->collection, function (Order $sellOrder) use ($buyOrder) {
            return $sellOrder->getName() === $buyOrder->getName() ?
                $buyOrder->getPrice() >= $sellOrder->getPrice() :
                false;
        });
        usort($filteredOrders, function (Order $order1, Order $order2) {
            if (($comparedPrice = $order1->getPrice() <=> $order2->getPrice()) !== 0) {
                return $comparedPrice;
            }

            return $order1->getCreatedAt() <=> $order2->getCreatedAt();
        });

        return $filteredOrders;
    }

    /**
     * @return Order[]
     */
    public function getAllForOrder(Order $buyOrder): array
    {
        $filteredOrders = array_filter($this->collection, function (Order $sellOrder) use ($buyOrder) {
            return $sellOrder->getName() === $buyOrder->getName() ?
                $buyOrder->getPrice() >= $sellOrder->getPrice() :
                false;
        });
        usort($filteredOrders, function (Order $order1, Order $order2) {
            return $order1->getPrice() <=> $order2->getPrice();
        });

        return $filteredOrders;
    }
}