<?php

namespace Application\Strategy\CommissionCalculator;

class DifferentCurrency implements AmountCalculationStrategy
{
    public function calculateAmount(float $amount, float $rate): float
    {
        return round($amount / $rate, 2);
    }
}