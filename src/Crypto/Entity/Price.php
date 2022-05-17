<?php

namespace App\Crypto\Entity;

use App\Crypto\Repository\PriceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PriceRepository::class)
 */
class Price
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $value;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $time;

    /**
     * @ORM\ManyToOne(targetEntity=CurrencyPair::class, inversedBy="prices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $currencyPair;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getTime(): ?\DateTimeImmutable
    {
        return $this->time;
    }

    public function setTime(\DateTimeImmutable $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getCurrencyPair(): ?CurrencyPair
    {
        return $this->currencyPair;
    }

    public function setCurrencyPair(?CurrencyPair $currencyPair): self
    {
        $this->currencyPair = $currencyPair;

        return $this;
    }
}
