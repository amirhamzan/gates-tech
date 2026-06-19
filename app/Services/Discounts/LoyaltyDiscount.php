<?php

namespace App\Services\Discounts;

use App\DiscountStrategyInterface;

class LoyaltyDiscount implements DiscountStrategyInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function calculate(float $originalPrice): float
    {
        return $originalPrice - (0.85 * $originalPrice);
    }
}
