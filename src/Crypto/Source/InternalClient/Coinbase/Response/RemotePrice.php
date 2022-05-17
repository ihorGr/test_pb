<?php

declare(strict_types=1);

namespace App\Crypto\Source\InternalClient\Coinbase\Response;

use App\Crypto\Source\InternalClient\Response\RemotePriceInterface;

class RemotePrice implements RemotePriceInterface
{
    public const BASE = 'base';
    public const CURRENCY = 'currency';
    public const AMOUNT = 'amount';

    /** @var array */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data['data'] ?? [];
    }

    public function getBase(): ?string
    {
        return (string) $this->data[self::BASE] ?? null;
    }

    public function getCurrency(): ?string
    {
        return (string) $this->data[self::CURRENCY] ?? null;
    }

    public function getAmount(): ?float
    {
        return (float) $this->data[self::AMOUNT] ?? null;
    }

    public function getPriceValue(): ?float
    {
        return $this->getAmount();
    }

}