<?php

declare(strict_types=1);

namespace App\Crypto\Source\Command;

use App\Crypto\Source\InternalClient\Coinbase\Request\GetPriceRequest;
use App\Crypto\Source\InternalClient\Exception\InternalApiException;
use App\Crypto\Source\InternalClient\Factory\InternalClientFactory;
use App\Crypto\Storage\CurrencyPair\Provider\ProviderInterface;
use App\Crypto\Storage\Price\Writer\DTO\InsertDataCollectorDto;
use App\Crypto\Storage\Price\Writer\WriterInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetCryptoCurrencyPriceCommand extends Command
{
    private ProviderInterface $provider;
    private InternalClientFactory $clientFactory;
    private WriterInterface $writer;
    private LoggerInterface $logger;

    public function __construct(ProviderInterface $provider, InternalClientFactory $clientFactory, WriterInterface $writer, LoggerInterface $logger)
    {
        $this->provider = $provider;
        $this->clientFactory = $clientFactory;
        $this->writer = $writer;
        $this->logger = $logger;

        parent::__construct();
    }

    public function configure()
    {
        $this
            ->setDescription('Get cryptocurrency price')
            ->setName('task-pb:get-cryptocurrency-price');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $currencyPairsList = $this->provider->getActiveCurrencyPairs();

        foreach ($currencyPairsList as $itemCurrencyPair) {
            try {
                $request = new GetPriceRequest($itemCurrencyPair);

                $remotePrice = $this->clientFactory->getClient()->getPrice($request);
            } catch (InternalApiException $e) {
                $this->logger->critical($e->getMessage());
                continue;
            }

            $dataCollectorsList[] = InsertDataCollectorDto::fromData($itemCurrencyPair, $remotePrice);
        }

        $this->writer->insertList($dataCollectorsList);
    }
}