<?php

declare(strict_types=1);

namespace App\Crypto\Api\v1\ResponseView;

interface ResultViewInterface extends \JsonSerializable
{
    public function toArray(): array;
}
