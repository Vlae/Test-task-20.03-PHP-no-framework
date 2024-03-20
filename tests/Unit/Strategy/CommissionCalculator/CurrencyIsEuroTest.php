<?php

namespace Application\Tests\Unit\Strategy\CommissionCalculator;

use PHPUnit\Framework\TestCase;
use Application\Tests\Unit\BaseTest;
use Application\Strategy\CommissionCalculator\CurrencyIsEuro;
use Application\Strategy\CommissionCalculator\AmountCalculationStrategy;

class CurrencyIsEuroTest extends TestCase
{
    private AmountCalculationStrategy $instance;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->instance = new CurrencyIsEuro();
    }

    public function test_euro_returns_same_amount()
    {
        $amount = 100.5;

        $this->assertEquals($this->instance->calculateAmount($amount, 0), $amount);
        $this->assertEquals($this->instance->calculateAmount($amount, 15), $amount);
    }
}