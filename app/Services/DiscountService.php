<?php

namespace App\Services;

use App\DiscountStrategyInterface;
use App\Services\Discounts\FixedDiscount;
use App\Services\Discounts\PercentageDiscount;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DiscountService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private DiscountStrategyInterface $strategy)
    {
        //
    }

    public function applyDiscount(float $price): float
    {
        if ($this->strategy instanceof PercentageDiscount) {
            $percentage = $this->strategy->calculate($price);
            if ($percentage < 0 || $percentage > 100) {
                throw new HttpException(400, 'Percentage discount, must between 0-100.');
            }
        }

        if ($this->strategy instanceof FixedDiscount) {
            $amount = $this->strategy->calculate($price);
            if ($amount < $price) {
                throw new HttpException(400, 'Fixed discount value, must not more than the original value.');
            }
        }

        return $this->strategy->calculate($price);
    }
}
