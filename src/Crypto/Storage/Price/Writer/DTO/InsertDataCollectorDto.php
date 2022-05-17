<?php

declare(strict_types=1);

namespace App\Crypto\Storage\Price\Writer\DTO;

use App\Crypto\Entity\CurrencyPair;
use App\Crypto\Source\InternalClient\Response\RemotePriceInterface;

class InsertDataCollectorDto
{
    private CurrencyPair $currencyPair;
    private RemotePriceInterface $remotePrice;

    /**
     * @param CurrencyPair $currencyPair
     * @param RemotePriceInterface $remotePrice
     */
    private function __construct(CurrencyPair $currencyPair, RemotePriceInterface $remotePrice)
    {
        $this->currencyPair = $currencyPair;
        $this->remotePrice = $remotePrice;
    }

    public static function fromData(CurrencyPair $currencyPair, RemotePriceInterface $remotePrice)
    {
        return new self($currencyPair, $remotePrice);
    }

    /**
     * @return CurrencyPair
     */
    public function getCurrencyPair(): CurrencyPair
    {
        return $this->currencyPair;
    }

    /**
     * @return RemotePriceInterface
     */
    public function getRemotePrice(): RemotePriceInterface
    {
        return $this->remotePrice;
    }

}