<?php

namespace App\Discount;

use App\DTO\OrderDTO;

interface DiscountInterface
{
    public function apply(OrderDTO $order): void;
}