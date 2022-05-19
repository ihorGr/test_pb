<?php

declare(strict_types=1);

namespace App\Crypto\Storage\Price\Provider;

use App\Crypto\Request\RequestInterface;

interface ProviderInterface
{
    public function getPrices(RequestInterface $request): array;
}