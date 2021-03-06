<?php

namespace App\Controller;

use App\Service\ExchangeRateService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ExchangeRateController
 * @package App\Controller
 */
#[Route('/api', name: '_api')]
class ExchangeRateController extends AbstractController
{
    /**
     * @param Request $request
     * @param ExchangeRateService $exchangeRateService
     *
     * @return Response
     */
    #[Route('/exchangeRate', name: 'exchange_rate', methods: 'GET')]
    public function getExchangeRate(Request $request, ExchangeRateService $exchangeRateService): Response
    {
        $currencyCode = $request->query->get('currencyCode');
        if (!$currencyCode)
            $currencyCode = 'EUR';
        $date = $request->query->get('date');
        if (!$date)
            $date = 'today/';

        try {
            return new Response($exchangeRateService->getExchangeRate($currencyCode, $date,
                                                                      $this->getDoctrine()->getManager()));
        } catch (Exception $e) {
            return new Response($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param ExchangeRateService $exchangeRateService
     *
     * @return Response
     */
    #[Route('/exchangeRate/historical', name: 'historical_exchange_rates', methods: 'GET')]
    public function getHistoricalExchangeRates(Request $request, ExchangeRateService $exchangeRateService): Response
    {
        $currencyCode = $request->query->get('currencyCode');
        if (!$currencyCode)
            $currencyCode = 'EUR';

        try {
            return new Response($exchangeRateService->getExchangeRates($currencyCode));
        } catch (Exception $e) {
            return new Response($e->getMessage());
        }
    }
}
