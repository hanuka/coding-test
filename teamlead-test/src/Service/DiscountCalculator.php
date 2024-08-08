<?php

namespace App\Service;

use App\Discount\CategoryDiscount;
use App\Discount\DiscountChain;
use App\Discount\FreeProductDiscount;
use App\Discount\TotalAmountDiscount;
use App\DTO\OrderDTO;

class DiscountCalculator
{
    private DiscountChain $discountChain;

    public function __construct(
        DiscountChain $discountChain,
        TotalAmountDiscount $totalAmountDiscount,
        CategoryDiscount $categoryDiscount,
        FreeProductDiscount $freeProductDiscount
    ) {
        $this->discountChain = $discountChain;

        // Add discounts to the chain
        $this->discountChain->addDiscount($categoryDiscount);
        $this->discountChain->addDiscount($freeProductDiscount);
        $this->discountChain->addDiscount($totalAmountDiscount);
    }

    public function calculateDiscount(OrderDTO $order): void
    {
        $this->discountChain->applyDiscounts($order);
    }
}