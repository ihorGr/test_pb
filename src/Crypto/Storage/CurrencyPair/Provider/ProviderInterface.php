<?php

declare(strict_types=1);

namespace App\Crypto\Storage\CurrencyPair\Provider;

use App\Crypto\Entity\CurrencyPair;

interface ProviderInterface
{
    /**
     * @return CurrencyPair[]
     */
    public function getActiveCurrencyPairs(): array;
}