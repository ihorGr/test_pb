<?php

declare(strict_types=1);

namespace App\Crypto\Storage\Price\Writer;

use App\Crypto\Entity\Price;
use App\Crypto\Storage\Price\Writer\DTO\InsertDataCollectorDto;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;

class Writer implements WriterInterface
{
    /** @var ManagerRegistry */
    protected $doctrine;

    /** @var LoggerInterface */
    protected $logger;

    /** @var ObjectManager */
    protected $pricetManager;

    public function __construct(ManagerRegistry $doctrine, LoggerInterface $logger)
    {
        $this->doctrine = $doctrine;
        $this->logger   = $logger;
        $this->pricetManager  = $this->doctrine->getManagerForClass(Price::class);
    }

    public function insert(InsertDataCollectorDto $dataCollectorDto): void
    {
        $newPrice = new Price();

        $newPrice
            ->setCurrencyPair($dataCollectorDto->getCurrencyPair())
            ->setValue($dataCollectorDto->getRemotePrice()->getPriceValue())
            ->setTime(new \DateTimeImmutable());

        $this->pricetManager->persist($newPrice);
    }

    /**
     * @param InsertDataCollectorDto[] $dataCollectorDtoList
     * @return void
     */
    public function insertList(array $dataCollectorDtoList): void
    {
        foreach ($dataCollectorDtoList as $dataCollectorDto) {
            $this->insert($dataCollectorDto);
        }

        $this->pricetManager->flush();
    }

}