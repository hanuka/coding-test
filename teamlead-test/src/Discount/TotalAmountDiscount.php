<?php

namespace App\Discount;

use App\DTO\OrderDTO;

class TotalAmountDiscount implements DiscountInterface
{

    public function apply(OrderDTO $order): void
    {
        //if $order->getTotal() - $order->getTotalDiscount() > 1000 ???
        if ($order->getTotal() > 1000) {
            $order->addTotalDiscount($order->getTotal() * 0.10);
            $order->addDiscountReason('10% discount for orders over 1000€');
        }
    }
}