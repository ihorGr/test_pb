<?php

declare(strict_types=1);

namespace App\Crypto\Api\v1\ResponseView\CryptoCurrency;

use App\Crypto\Api\v1\ResponseView\ResultViewInterface;

class GetPricesResponse implements ResultViewInterface
{
    public const CURRENCY_PAIR = 'currency_pair';
    public const PRICES = 'prices';

    /**
     * @param string $currencyPair
     */
    public function __construct(array $resultView)
    {
        $this->data = $resultView;
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}