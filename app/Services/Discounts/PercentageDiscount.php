<?php

namespace App\Services\Discounts;

use App\DiscountStrategyInterface;

class PercentageDiscount implements DiscountStrategyInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(private float $percentage)
    {
        //
    }

    public function calculate(float $originalPrice): float
    {
        return $originalPrice - ($this->percentage * $originalPrice);
    }
}
