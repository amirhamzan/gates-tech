<?php

namespace App\Services\Discounts;

use App\DiscountStrategyInterface;

class FixedDiscount implements DiscountStrategyInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(private float $amount) {}

    public function calculate(float $originalPrice): float
    {
        return $originalPrice - $this->amount;
    }
}
