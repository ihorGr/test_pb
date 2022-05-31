<?php

declare(strict_types=1);

namespace App\Crypto\Storage\Price\Provider;

use App\Crypto\Request\RequestInterface;
use App\Crypto\Storage\Price\Provider\DTO\PriceDto;
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

        $pricesCollection = [];

        foreach ($pricesList as $itemPrice) {
            try {
                $normalizers = [new PropertyNormalizer()];
                $serializer = new Serializer($normalizers);

                $pricesCollection[] = $serializer->denormalize($itemPrice, PriceDto::class);
            } catch (\Throwable $e) {
                throw new \RuntimeException($e->getMessage());
            }
        }

        return $pricesCollection;
    }
}