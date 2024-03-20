<?php

namespace Application\Providers\CurrencyRate;

use Application\Contracts\Authenticatible;
use Application\Contracts\CurrencyRateProviderInterface;

class ExchangeRateApiProvider implements CurrencyRateProviderInterface, Authenticatible
{
    private const ULR = 'https://api.exchangeratesapi.net/v1/exchange-rates/latest';

    /** @var string  */
    private string $urlAuthenticated;

    /**
     * Simplified version of authentication
     *
     * @return void
     */
    public function auth(): void
    {
        $this->urlAuthenticated = self::ULR . '?access_key=' . $_ENV['EXCHANGE_RATE_API_TOKEN'];
    }

    /**
     * @param string $currency
     *
     * @return float
     */
    public function getRateByCurrency(string $currency): float
    {
        $rateJson = file_get_contents($this->urlAuthenticated);

        return @json_decode($rateJson, true)['rates'][$currency];
    }
}