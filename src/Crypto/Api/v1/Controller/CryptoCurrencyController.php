<?php

declare(strict_types=1);

namespace App\Crypto\Api\v1\Controller;

use App\Crypto\Api\Controller\AbstractApiController;
use App\Crypto\Api\v1\Request\GetPricesRequest;
use App\Crypto\Api\v1\Resolver\ResolverInterface;
use App\Crypto\Api\v1\ResponseView\DataResultView;
use App\Crypto\Api\v1\ResponseView\Exception\ResponseViewInstanceException;
use App\Crypto\Storage\Price\Provider\ProviderInterface as PriceProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

class CryptoCurrencyController extends AbstractApiController
{
    /**
     * @Route("/api/get_prices", name="get_prices", methods={"GET"})
     */
    public function getPrices(Request $request, PriceProviderInterface $provider, ResolverInterface $resolver, LoggerInterface $logger): Response
    {
        try {
            $getPricesRequest = GetPricesRequest::fromRequest($request->query->all());

            if (null !== $errorResponse = $this->validate($getPricesRequest)) {
                return $errorResponse;
            }

            $pricesList = $provider->getPrices($getPricesRequest);

            $resultView = $resolver->resolveGetPrices($getPricesRequest, $pricesList);

            $dataResultView = new DataResultView($resultView);

        } catch (ResponseViewInstanceException $e) {
            $logger->critical($e->getMessage());
            return new JsonResponse(['errors' => 'Internal error. Please try again later'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\RuntimeException $e) {
            return new JsonResponse(['errors' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($dataResultView, JsonResponse::HTTP_OK);
    }
}