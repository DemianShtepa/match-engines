<?php

declare(strict_types=1);

namespace App;

final class SellOrderCollection extends OrderCollection
{
    /**
     * @return Order[]
     */
    public function getByName(string $name): array
    {
        $filteredOrders = array_filter($this->collection, function (Order $order) use ($name) {
            return $order->getName() === $name;
        });
        usort($filteredOrders, function (Order $order1, Order $order2) {
            if (($comparedPrice = $order1->getPrice() <=> $order2->getPrice()) !== 0) {
                return $comparedPrice;
            }

            return $order1->getCreatedAt() <=> $order2->getCreatedAt();
        });

        return $filteredOrders;
    }
}