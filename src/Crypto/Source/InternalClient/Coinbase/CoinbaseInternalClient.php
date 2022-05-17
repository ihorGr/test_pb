<?php

declare(strict_types=1);

namespace App\Crypto\Source\InternalClient\Coinbase;

use App\Crypto\Source\InternalClient\Coinbase\Response\RemotePrice;
use App\Crypto\Source\InternalClient\InternalClientInterface;
use App\Crypto\Source\InternalClient\Request\GetPriceRequestInterface;
use App\Crypto\Source\InternalClient\Response\RemotePriceInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface as HttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use App\Crypto\Source\InternalClient\Exception\InternalApiException;

class CoinbaseInternalClient implements InternalClientInterface
{
    public const HOST = 'https://api.coinbase.com';
    public const PATH = 'v2/prices/%s/spot';

    /** @var HttpClientInterface */
    protected $connection;

    /**
     * @param GetPriceRequestInterface $getPriceRequest
     * @return RemotePrice
     * @throws InternalApiException
     */
    public function getPrice(GetPriceRequestInterface $getPriceRequest): RemotePriceInterface
    {
        $apiUrl = $this->createApiUrl($getPriceRequest);

        $response = $this->sendRequest($apiUrl);

        try {
            $response = $response->toArray();
        } catch (HttpException $exception) {
            throw new InternalApiException($exception);
        }

        return new RemotePrice($response);
    }

    /**
     * @param string $endpoint
     * @param string $body
     * @return ResponseInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    protected function sendRequest(string $apiUrl) : ResponseInterface
    {
        $response = $this->createConnection()->request('GET', $apiUrl);

        $responseStatus = $response->getStatusCode();

        if ($responseStatus >= 400) {
            $responseContent = $response->getContent(false);
            throw new InternalApiException($responseContent);
        }

        return $response;
    }

    protected function createApiUrl(GetPriceRequestInterface $request) : string
    {
        $path = sprintf(self::PATH, $request->getPair());

        return sprintf('%s/%s', self::HOST, $path);
    }

    protected function createConnection() : HttpClientInterface
    {
        if (null === $this->connection) {
            $this->connection = HttpClient::create();
        }

        return $this->connection;
    }
}
