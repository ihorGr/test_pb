<?php

declare(strict_types=1);

namespace App\Crypto\Source\InternalClient\Response;

interface RemotePriceInterface
{
    public function getPriceValue(): ?float;
}