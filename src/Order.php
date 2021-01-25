<?php

declare(strict_types=1);

namespace App;

use DateTimeImmutable;

final class Order
{
    private int $id;
    private string $name;
    private DateTimeImmutable $createdAt;
    private float $price;
    private int $quantity;

    public function __construct(int $id, string $name, float $price, int $quantity, DateTimeImmutable $createdAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
}