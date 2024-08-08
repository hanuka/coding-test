<?php

namespace App\DTO;

class OrderItemDTO
{
    /**
     * @Assert\NotBlank(message="The product-id field is required.")
     * @Assert\Type(type="string", message="The product-id field must be a string.")
     */
    private string $productId;

    /**
     * @Assert\NotBlank(message="The quantity field is required.")
     * @Assert\Type(type="integer", message="The quantity field must be an integer.")
     * @Assert\PositiveOrZero(message="The quantity must be zero or positive.")
     */
    private int $quantity;

    /**
     * @Assert\NotBlank(message="The unit-price field is required.")
     * @Assert\Type(type="numeric", message="The unit-price field must be a number.")
     * @Assert\PositiveOrZero(message="The unit-price must be zero or positive.")
     */
    private float $unitPrice;

    /**
     * @Assert\NotBlank(message="The total field is required.")
     * @Assert\Type(type="numeric", message="The total field must be a number.")
     * @Assert\PositiveOrZero(message="The total must be zero or positive.")
     */
    private float $total;

    public function __construct(string $productId, int $quantity, float $unitPrice, float $total)
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->unitPrice = $unitPrice;
        $this->total = $total;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    public function getTotal(): float
    {
        return $this->total;
    }
}