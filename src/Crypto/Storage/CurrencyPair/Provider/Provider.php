<?php

declare(strict_types=1);

namespace App\Crypto\Storage\CurrencyPair\Provider;

use App\Crypto\Entity\CurrencyPair;
use App\Crypto\Repository\CurrencyPairRepository;
use Doctrine\Persistence\ManagerRegistry;

class Provider implements ProviderInterface
{
    /** @var ManagerRegistry */
    protected $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @return CurrencyPair[]
     */
    public function getActiveCurrencyPairs(): array
    {
        return $this->getPriceRepository()->findBy(
            ['active' => 1],
            ['id' => 'ASC']
        );
    }

    protected function getPriceRepository(): CurrencyPairRepository
    {
        return $this->doctrine->getRepository(CurrencyPair::class);
    }
}