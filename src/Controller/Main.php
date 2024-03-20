<?php

namespace Application\Controller;

use Application\Utils\TextFileReader;
use Application\Providers\Bin\BinListProvider;
use Application\Service\CommissionCalculatorService;
use Application\Providers\CurrencyRate\ExchangeRateApiProvider;

class Main
{
    /**
     * @return void
     */
    public function calculateCommissions(): void
    {
        $fileReader = new TextFileReader( 'input.txt');
        $binListProvider = new BinListProvider();
        $currencyRateProvider = new ExchangeRateApiProvider();
        $currencyRateProvider->auth();

        $service = new CommissionCalculatorService($fileReader, $binListProvider, $currencyRateProvider);
        $commissions = $service->getCommissions();

        foreach ($commissions as $commission) {
            echo $commission . PHP_EOL;
        }
    }
}