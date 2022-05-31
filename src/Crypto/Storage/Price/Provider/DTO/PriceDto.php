<?php

declare(strict_types=1);

namespace App\Crypto\Storage\Price\Provider\DTO;

class PriceDto
{
    private int $id;
    private float $value;
    private string $time;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getValue(): ?float
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getTime(): ?string
    {
        return $this->time;
    }

}