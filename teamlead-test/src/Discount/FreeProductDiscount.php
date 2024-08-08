<?php

namespace App\Discount;

use App\DTO\OrderDTO;
use App\DTO\OrderItemDTO;

class FreeProductDiscount implements DiscountInterface
{
    private int $requiredQuantity = 5;
    private int $freeQuantity = 1;

    /**
     * If the customer buys more than 5 he will get the number of products divided by 5
     * If the total number of products divided by 5 as int is lower or equal with the rest of product divided by 5
     *
     * @param OrderDTO $order
     * @return void
     */
    public function apply(OrderDTO $order): void
    {

        /** @var OrderItemDTO[] $itemsInCategory */
        $itemsInCategory = $this->getItemsByCategory($order->getItems());

        if (empty($itemsInCategory)) {
            return;
        }

        $maxFreeProducts = 0;
        $availableFreeProducts = 0;
        $totalProducts = 0;
        $discount = 0;
        $itemKey = 0;
        $itemList = [];

        foreach ($itemsInCategory as $key => $item) {
            $totalProducts += $item->getQuantity();
            $itemList[$key]['price'] = $item->getUnitPrice();
            $itemList[$key]['quantity'] = $item->getQuantity();
        }
        usort($itemList, function ($a, $b) {
            return $a['price'] <=> $b['price'];
        });


        $maxFreeProducts = intdiv($totalProducts,$this->requiredQuantity);
        $availableFreeProducts = fmod($totalProducts,$this->requiredQuantity);


        if ($maxFreeProducts > $availableFreeProducts) {
            $maxFreeProducts -=1;
        }

        if ($maxFreeProducts > 0) {
            $order->addDiscountReason('You get '. $maxFreeProducts . ' of category of Switches');
        }

        while($maxFreeProducts > 0) {
            if ($itemList[$itemKey]['quantity'] >= $maxFreeProducts) {
                $discount += $itemList[$itemKey]['price'] * $maxFreeProducts;
            } else {
                $discount += $itemList[$itemKey]['price'] * $itemList[$itemKey]['quantity'];
            }
            $maxFreeProducts -= $itemList[$itemKey]['quantity'];
            $itemKey ++;
        }

        $order->addTotalDiscount($discount);
    }

    private function getItemsByCategory(array $items): array
    {
        $result = [];
        /** @var OrderItemDTO $item */
        foreach($items as $item) {
            if (str_starts_with($item->getProductId(), 'B')) {
                $result[] = $item;
            }
        }

        return $result;
    }
}