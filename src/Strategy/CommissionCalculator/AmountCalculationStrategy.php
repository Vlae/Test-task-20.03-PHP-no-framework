<?php

namespace Application\Strategy\CommissionCalculator;

interface AmountCalculationStrategy
{
    public function calculateAmount(float $amount, float $rate): float;
}