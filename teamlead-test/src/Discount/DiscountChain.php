<?php

namespace App\Discount;

use App\DTO\OrderDTO;

class DiscountChain
{
    private array $discounts = [];

    public function addDiscount(DiscountInterface $discount): void
    {
        $this->discounts[] = $discount;
    }

    public function applyDiscounts(OrderDTO $order): void
    {
        foreach ($this->discounts as $discount) {
            $discount->apply($order);
        }
    }
}