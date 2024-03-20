<?php

namespace Application\Contracts;

interface BinProviderInterface
{
    public function getCardMetaData(string $bin): DTO;
}