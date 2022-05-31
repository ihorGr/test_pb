<?php

declare(strict_types=1);

namespace App\Crypto\Api\v1\Resolver;

use App\Crypto\Api\v1\Request\GetPricesRequest;
use App\Crypto\Api\v1\ResponseView\CryptoCurrency\GetPricesResponse;
use App\Crypto\Api\v1\ResponseView\CryptoCurrency\PriceView;
use App\Crypto\Api\v1\ResponseView\ListResultView;
use App\Crypto\Storage\Price\Provider\DTO\PriceDto;

class Resolver implements ResolverInterface
{
    /**
     * @param GetPricesRequest $getPricesRequest
     * @param PriceDto[] $pricesList
     * @return GetPricesResponse
     */
    public function resolveGetPrices(GetPricesRequest $getPricesRequest, array $pricesList): GetPricesResponse
    {
        $resultView = [
            GetPricesResponse::CURRENCY_PAIR => $getPricesRequest->getCurrencyPair(),
            GetPricesResponse::PRICES => $this->resolvePrices($pricesList)
        ];

        return new GetPricesResponse($resultView);
    }

    private function resolvePrices(array $pricesList): ListResultView
    {
        $pricesViewList = [];

        foreach ($pricesList as $item) {
            $pricesViewList[] = $this->resolvePrice($item);
        }

        return new ListResultView($pricesViewList);
    }

    private function resolvePrice(PriceDto $price): PriceView
    {
        $priceView = [
            PriceView::VALUE => $price->getValue(),
            PriceView::TIME => $price->getTime()
        ];

        return new PriceView($priceView);
    }
}