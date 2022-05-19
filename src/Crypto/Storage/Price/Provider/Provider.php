<?php

declare(strict_types=1);

namespace App\Crypto\Storage\Price\Provider;

use App\Crypto\Request\RequestInterface;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;

class Provider implements ProviderInterface
{
    /** @var ManagerRegistry */
    protected $doctrine;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getPrices(RequestInterface $request): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'p.id',
                'p.value',
                'p.time'
            )
            ->from('price', 'p')
            ->innerJoin('p', 'currency_pair', 'cp', 'p.currency_pair_id = cp.id')
            ->where('cp.base = :base AND cp.quoted = :quoted AND cp.active = 1')
            ->andWhere('p.time BETWEEN :from AND :to')
            ->setParameter(':base', $request->getBase())
            ->setParameter(':quoted', $request->getQuoted())
            ->setParameter(':from', $request->getFrom())
            ->setParameter(':to', $request->getTo())
            ->orderBy('p.time', 'DESC' )
            ->execute();

        return $stmt->fetchAllAssociative();
    }

}