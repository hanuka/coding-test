<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class OrderDTO
{
    private string $id;

    private string $customerId;

    /**
     * @param string $customerId
     */
    public function setCustomerId(string $customerId): void
    {
        $this->customerId = $customerId;
    }

    private array $items = [];

    /**
     * @param OrderItemDTO[] $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    private float $total = 0;

    /**
     * @param float $total
     */
    public function setTotal(float $total): void
    {
        $this->total = $total;
    }

    private float $totalDiscount = 0;
    private string $discountReason = '';

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    /**
     * @return OrderItemDTO[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function addTotalDiscount(float $discount): void
    {
        $this->totalDiscount += $discount;
    }

    public function getTotalDiscount(): float
    {
        return $this->totalDiscount;
    }

    public function addDiscountReason(string $reason): void
    {
        if ($this->discountReason) {
            $this->discountReason = $this->discountReason . ' and ' . $reason;
        } else {
            $this->discountReason = $reason;
        }

    }

    public function getDiscountReason(): string
    {
        return $this->discountReason;
    }
}