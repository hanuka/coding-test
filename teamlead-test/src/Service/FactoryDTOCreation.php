<?php

namespace App\Service;

use App\DTO\OrderDTO;
use App\DTO\OrderItemDTO;

class FactoryDTOCreation
{

    public function createOrderDTO(array $data): OrderDTO
    {
        $items = array_map(function($item) {
            return new OrderItemDTO(
                $item['product-id'],
                (int) $item['quantity'],
                (float) $item['unit-price'],
                (float) $item['total']
            );
        }, $data['items']);

        $orderDTO = new OrderDTO();
        $orderDTO->setId($data['id']);
        $orderDTO->setCustomerId($data['customer-id']);
        $orderDTO->setTotal($data['total']);
        $orderDTO->setItems($items);

        return $orderDTO;
    }
}