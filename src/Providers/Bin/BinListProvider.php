<?php

namespace Application\Providers\Bin;

use Application\DTO\CardMetaDataDTO;
use Application\Contracts\BinProviderInterface;

class BinListProvider implements BinProviderInterface
{
    private const URL = 'https://lookup.binlist.net/';

    /**
     * @param string $bin
     *
     * @return CardMetaDataDTO
     * @throws \Exception
     */
    public function getCardMetaData(string $bin): CardMetaDataDTO
    {
        $binResultJson = file_get_contents(self::URL . $bin);

        if (!$binResultJson) {
            throw new \Exception('Information for this INN is not found or Error happened');
        }

        $binArray = json_decode($binResultJson);

        return new CardMetaDataDTO($binArray->scheme, $binArray->type, $binArray->country->alpha2);
    }
}