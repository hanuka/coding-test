<?php

namespace App\Discount;

use App\DTO\OrderDTO;
use App\DTO\OrderItemDTO;

class CategoryDiscount implements DiscountInterface
{
    private float $discountRate = 0.2;

    public function apply(OrderDTO $order): void
    {
        $itemsInCategory = $this->getItemsByCategory($order->getItems());

        if (count($itemsInCategory) >= 2) {
            $cheapestItemPrice = min(array_map(fn(OrderItemDTO $item) => $item->getUnitPrice(), $itemsInCategory));

            $order->addTotalDiscount(round($cheapestItemPrice * $this->discountRate, 2));
            $order->addDiscountReason(
                '20% discount for buying ' . count($itemsInCategory) . ' items in the category Tools'
            );
        }
    }

    private function getItemsByCategory(array $items): array
    {
        $result = [];
        /** @var OrderItemDTO $item */
        foreach($items as $item) {
            if (str_starts_with($item->getProductId(), 'A')) {
                $result[] = $item;
            }
        }

        return $result;
    }
}