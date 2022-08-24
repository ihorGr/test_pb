<?php

declare(strict_types=1);

namespace App\Crypto\Storage\Price\Provider;

use App\Crypto\Request\RequestInterface;
use App\Crypto\Storage\Price\Provider\DTO\PriceDto;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProviderProxy extends Provider implements ProviderInterface
{
    /**
     * @param RequestInterface $request
     * @return PriceDto[]
     */
    public function getPrices(RequestInterface $request): array
    {
        $pricesList = parent::getPrices($request);

        $pricesCollection = $this->denormalizeList($pricesList);

        return $pricesCollection;
    }

    /**
     * @param array[] $pricesList
     * @return PriceDto[]
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    private function denormalizeList(array $pricesList): array
    {
        $normalizers = [new PropertyNormalizer(), new ArrayDenormalizer()];
        $serializer = new Serializer($normalizers);

        return $serializer->denormalize($pricesList, PriceDto::class.'[]');
    }
}