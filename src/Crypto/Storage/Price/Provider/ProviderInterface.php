<?php

declare(strict_types=1);

namespace App\Crypto\Storage\Price\Provider;

use App\Crypto\Entity\Price;

interface ProviderInterface
{
    /**
     * @return Price[]
     */
    public function getActiveCurrencyPairs(): array;
}