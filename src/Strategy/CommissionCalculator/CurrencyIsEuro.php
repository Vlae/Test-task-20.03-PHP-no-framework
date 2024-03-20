<?php

namespace Application\Strategy\CommissionCalculator;

class CurrencyIsEuro implements AmountCalculationStrategy
{
    public function calculateAmount(float $amount, float $rate): float
    {
        return $amount;
    }

}