<?php

declare(strict_types=1);

namespace App\Crypto\Source\InternalClient\Factory;

use App\Crypto\Source\InternalClient\InternalClientInterface;

class InternalClientFactory
{
    protected InternalClientInterface $internalClient;

    public function __construct(InternalClientInterface $internalClient)
    {
        $this->internalClient = $internalClient;
    }

    public function getClient(): InternalClientInterface
    {
        return $this->internalClient;
    }
}