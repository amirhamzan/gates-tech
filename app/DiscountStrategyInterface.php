<?php

namespace App;

interface DiscountStrategyInterface
{
    public function calculate(float $originalPrice): float;
}
