<?php

declare(strict_types=1);

namespace App\Crypto\Api\v1\ResponseView\CryptoCurrency;

use App\Crypto\Api\v1\ResponseView\ResultViewInterface;

class PriceView implements ResultViewInterface
{
    public const VALUE = 'value';
    public const TIME = 'time';

    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function toArray(): array
    {
        return [
            'value' => $this->data[self::VALUE],
            'time' => $this->data[self::TIME],
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}