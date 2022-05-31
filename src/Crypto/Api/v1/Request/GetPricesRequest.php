<?php

declare(strict_types=1);

namespace App\Crypto\Api\v1\Request;

use App\Crypto\Api\Request\ApiRequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

class GetPricesRequest implements ApiRequestInterface
{
    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Regex(
     *     pattern="/[A-Z]{3}-[A-Z]{3}$/",
     *     message="Invalid currency pair pattern. Please see documentation"
     * )
     */
    private $currencyPair;

    /**
     * @Assert\NotBlank
     * @Assert\DateTime()
     * @Assert\Length(min=3)
     */
    private $from;
    /**
     * @Assert\NotBlank
     * @Assert\DateTime()
     * @Assert\Length(min=3)
     */
    private $to;

    /**
     * @param array|null $data
     */
    private function __construct(?array $data)
    {
        $this->currencyPair = $data['currency_pair'] ?? null;
        $this->from = $data['from'] ?? null;
        $this->to = $data['to'] ?? null;
    }

    /**
     * @return mixed|null
     */
    public function getCurrencyPair()
    {
        return $this->currencyPair;
    }

    /**
     * @return mixed|null
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return mixed|null
     */
    public function getTo()
    {
        return $this->to;
    }

    public static function fromRequest(?array $requestData): self
    {
        return new self($requestData);
    }

    public function getBase()
    {
        return explode('-', $this->currencyPair)[0];
    }

    public function getQuoted()
    {
        return explode('-', $this->currencyPair)[1];
    }
}