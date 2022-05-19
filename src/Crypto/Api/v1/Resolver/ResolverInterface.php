<?php

declare(strict_types=1);

namespace App\Crypto\Api\v1\Resolver;

use App\Crypto\Api\v1\Request\GetPricesRequest;
use App\Crypto\Api\v1\ResponseView\CryptoCurrency\GetPricesResponse;

interface ResolverInterface
{
    public function resolveGetPrices(GetPricesRequest $getPricesRequest, array $pricesList): GetPricesResponse;
}