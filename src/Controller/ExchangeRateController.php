<?php

namespace App\Controller;

use App\Service\ExchangeRateService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: '_api')]
class ExchangeRateController extends AbstractController
{
    #[Route('/exchangeRate', name: 'exchange_rate', methods: 'GET')]
    public function getExchangeRate(Request $request, ExchangeRateService $exchangeRateService): Response
    {
        $currencyCode = $request->query->get('currencyCode');
        if (!$currencyCode)
            $currencyCode = 'EUR';
        $date = $request->query->get('$date');
        if (!$date)
            $date = 'today/';

        try {
            $exchangeRateService->getExchangeRate($currencyCode, $date);
        } catch (Exception $e) {
        }

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ExchangeRateController.php',
        ]);
    }
}
