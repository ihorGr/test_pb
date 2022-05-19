<?php

declare(strict_types=1);

namespace App\Crypto\Api\v1\ResponseView;

use App\Crypto\Api\v1\ResponseView\Exception\ResponseViewInstanceException;

class DataResultView implements ResultViewInterface
{
    public const FIELD_DATA = 'data';

    /** @var array|ResultViewInterface */
    protected $data;

    public function __construct($data)
    {
        if (!is_array($data) && (!is_object($data) || !$data instanceof ResultViewInterface)) {
            throw ResponseViewInstanceException::fromWrongItemInstance(
                is_object($data) ? get_class($data) : gettype($data),
                'array or ' . ResultViewInterface::class
            );
        }

        $this->data = $data;
    }

    public function toArray(): array
    {
        return [self::FIELD_DATA => $this->data];
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
