<?php

namespace Application\Service;

use Application\Enums\Currencies;
use Application\Enums\EuCountryCodes;
use Application\Contracts\FileReaderInterface;
use Application\Contracts\BinProviderInterface;
use Application\Contracts\CurrencyRateProviderInterface;
use Application\Strategy\CommissionCalculator\CurrencyIsEuro;
use Application\Strategy\CommissionCalculator\DifferentCurrency;

class CommissionCalculatorService
{
    private const EU_COMMISSION_RATE = 0.01;
    private const NON_EU_COMMISSION_RATE = 0.02;

    /** @var string  */
    private string $amount;
    /** @var string  */
    private string $currency;

    /**
     * @param FileReaderInterface           $fileReader
     * @param BinProviderInterface          $binProvider
     * @param CurrencyRateProviderInterface $rateProvider
     */
    public function __construct(
        private readonly FileReaderInterface $fileReader,
        private readonly BinProviderInterface $binProvider,
        private readonly CurrencyRateProviderInterface $rateProvider,
    ) {
    }

    /**
     * Read file, calculate commission and output value to command line
     */
    public function getCommissions(): array
    {
        $commissions = [];
        try {
            while (!$this->fileReader->isEndOfFile()) {
                $data = $this->fileReader->readLine();

                $this->amount = $data['amount'];
                $this->currency = $data['currency'];

                $cardMetaDataDTO = $this->binProvider->getCardMetaData($data['bin']);
                $rate = $this->rateProvider->getRateByCurrency($data['currency']);

                $amount = $this->calculate($rate, $cardMetaDataDTO->getCountryCode());

                $commissions[] = $amount;
            }
        } catch (\Exception $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }


        return $commissions;
    }

    /**
     * @param string $rate
     * @param string $countryCode
     *
     * @return float
     */
    private function calculate(string $rate, string $countryCode): float
    {
        if ($this->currency === Currencies::EURO->value || $rate == 0) {
            $calculationStrategy = new CurrencyIsEuro();
        } else {
            $calculationStrategy = new DifferentCurrency();
        }

        $amount = $calculationStrategy->calculateAmount($this->amount, $rate);
        $commissionPercentage = $this->getCommissionPercentageForCountry($countryCode);

        return round($amount * $commissionPercentage, 2);
    }

    /**
     * @param string $countryCode
     *
     * @return float
     */
    private function getCommissionPercentageForCountry(string $countryCode): float
    {
        return $this->isEuCountry($countryCode) ? self::EU_COMMISSION_RATE : self::NON_EU_COMMISSION_RATE;
    }

    /**
     * @param string $countryCode
     *
     * @return bool
     */
    private function isEuCountry(string $countryCode): bool
    {
        return in_array($countryCode, EuCountryCodes::getAllCountries());
    }
}