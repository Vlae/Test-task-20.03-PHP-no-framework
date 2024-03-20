<?php

namespace Application\Contracts;

interface CurrencyRateProviderInterface
{
    public function getRateByCurrency(string $currency): float;
}