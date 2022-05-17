<?php

declare(strict_types=1);

namespace App\Crypto\Source\InternalClient\Coinbase\Request;

use App\Crypto\Entity\CurrencyPair;
use App\Crypto\Source\InternalClient\Request\GetPriceRequestInterface;

class GetPriceRequest implements GetPriceRequestInterface
{
    private $currencyPair;

    public function __construct(CurrencyPair $currencyPair)
    {
        $this->currencyPair = $currencyPair;
    }

    public function getPair(): string
    {
        return sprintf('%s-%s', $this->currencyPair->getBase(), $this->currencyPair->getQuoted());
    }
}