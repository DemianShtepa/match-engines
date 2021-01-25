<?php

declare(strict_types=1);

namespace App;

use DateTimeImmutable;

final class Matcher
{
    private BuyOrderCollection $buyOrderCollection;
    private SellOrderCollection $sellOrderCollection;
    /** @var OrderPair[] */
    private array $orderPairs;

    public function __construct(BuyOrderCollection $buyOrderCollection, SellOrderCollection $sellOrderCollection)
    {
        $this->buyOrderCollection = $buyOrderCollection;
        $this->sellOrderCollection = $sellOrderCollection;
        $this->orderPairs = [];
    }

    public function priceTimeMatch(): void
    {
        foreach ($this->buyOrderCollection->getOrders() as $buyOrderKey => $buyOrder) {
            $sellOrdersForName = $this->sellOrderCollection->getByName($buyOrder->getName());
            foreach ($sellOrdersForName as $sellOrderKey => $sellOrder) {
                if ($buyOrder->getPrice() < $sellOrder->getPrice()) {
                    break;
                }

                $quantityDiff = $buyOrder->getQuantity() - $sellOrder->getQuantity();

                if ($quantityDiff > 0) {
                    $this->sellOrderCollection->removeByKey($buyOrderKey);

                    $this->orderPairs[] = new OrderPair($buyOrder, $sellOrder, $sellOrder->getQuantity(), new DateTimeImmutable());

                    $buyOrder->setQuantity($quantityDiff);

                    continue;
                } elseif ($quantityDiff === 0) {
                    $this->sellOrderCollection->removeByKey($sellOrderKey);
                    $this->buyOrderCollection->removeByKey($buyOrderKey);

                    $this->orderPairs[] = new OrderPair($buyOrder, $sellOrder, $sellOrder->getQuantity(), new DateTimeImmutable());

                    break;
                } else {
                    $this->buyOrderCollection->removeByKey($buyOrderKey);

                    $this->orderPairs[] = new OrderPair($buyOrder, $sellOrder, $buyOrder->getQuantity(), new DateTimeImmutable());

                    $sellOrder->setQuantity(-$quantityDiff);
                }
            }
        }
    }
}