<?php

declare(strict_types=1);

namespace App\Crypto\Storage\Price\Provider;

use App\Crypto\Entity\Price;
use App\Crypto\Repository\PriceRepository;
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
     * @return Price[]
     */
    public function getActiveCurrencyPairs(): array
    {
        return $this->getPriceRepository()->findBy(
            ['active' => 1],
            ['id' => 'ASC']
        );
    }

    protected function getPriceRepository(): PriceRepository
    {
        return $this->doctrine->getRepository(Price::class);
    }
}