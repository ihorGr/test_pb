<?php

declare(strict_types=1);

namespace App\Crypto\Api\v1\ResponseView\Exception;

use App\Crypto\Api\v1\ResponseView\ResultViewInterface;

class ResponseViewInstanceException extends \RuntimeException
{
    public const WRONG_INSTANCE_TPL = 'Expected instance of %s, given instance of %s';

    public static function fromWrongItemInstance(
        string $givenInstanceClass,
        string $expectedInstanceClass = ResultViewInterface::class
    ): self {
        return new self(sprintf(self::WRONG_INSTANCE_TPL, $expectedInstanceClass, $givenInstanceClass));
    }
}
