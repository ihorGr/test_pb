<?php

declare(strict_types=1);

namespace App\Crypto\Api\v1\ResponseView;

use App\Crypto\Api\v1\ResponseView\Exception\ResponseViewInstanceException;

/**
 * Contains list of other ResultViews
 */
class ListResultView implements ResultViewInterface
{
    /** @var ResultViewInterface[] */
    protected $list;

    /**
     * @param object[] $list
     * @throws ResponseViewInstanceException
     */
    public function __construct(array $list)
    {
        foreach ($list as $resultView) {
            if (!is_object($resultView)) {
                throw ResponseViewInstanceException::fromWrongItemInstance(gettype($resultView));
            }

            if (!$resultView instanceof ResultViewInterface) {
                throw ResponseViewInstanceException::fromWrongItemInstance(get_class($resultView));
            }
        }

        $this->list = $list;
    }

    public function toArray(): array
    {
        return $this->list;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
