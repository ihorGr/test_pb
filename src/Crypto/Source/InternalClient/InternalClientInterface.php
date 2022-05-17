<?php

declare(strict_types = 1);

namespace App\Crypto\Source\InternalClient;

use App\Crypto\Source\InternalClient\Request\GetPriceRequestInterface;
use App\Crypto\Source\InternalClient\Response\RemotePriceInterface;

interface InternalClientInterface
{
    public function getPrice(GetPriceRequestInterface $getPriceRequest): RemotePriceInterface;
}
