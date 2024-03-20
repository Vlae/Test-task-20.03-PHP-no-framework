<?php

namespace Application\DTO;

use Application\Contracts\DTO;

class CardMetaDataDTO implements DTO
{
    /** @var string  */
    private string $scheme;
    /** @var string  */
    private string $type;
    /** @var string  */
    private string $countryCode;

    /**
     * @param string $scheme
     * @param string $type
     * @param string $countryCode
     */
    public function __construct(string $scheme, string $type, string $countryCode)
    {
        $this->scheme = $scheme;
        $this->type = $type;
        $this->countryCode = $countryCode;
    }

    /**
     * @return string
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }
}