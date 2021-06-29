<?php


namespace App\Service;


use DateTime;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ExchangeRateService
{
    private const HTTP_GET = 'GET';
    private const NBP_API_URL = 'http://api.nbp.pl/api/exchangerates/rates/a/';
    private const PARAMS = ['query' => ['format' => 'json']];
    private const CURRENCY_CODE_LENGTH = 3;
    private const DEFAULT_DATE_PARAM = 'today/';

    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getExchangeRate(string $currencyCode, string $date)
    {
        try {
            $this->validateParams($currencyCode, $date);
            $this->fetchExchangeRate($currencyCode, $date);
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function validateParams(string $currencyCode, string $date)
    {
        if (strlen($currencyCode) != self::CURRENCY_CODE_LENGTH)
            throw new Exception('Bad country code format. Please provide 3 letters code.');

        if ($date && $date !== self::DEFAULT_DATE_PARAM) {
            $dateTime = DateTime::createFromFormat("Y-m-d", $date);
            if ($dateTime === false || array_sum($dateTime::getLastErrors()))
                throw new Exception('Bad date format. Please provide YYYY-MM-DD date.');
        }
    }

    private function fetchExchangeRate(string $currencyCode, string $date)
    {
        $exchangeRateApiUrl = self::NBP_API_URL . $currencyCode . '/' . $date;

        try {
            $response = $this->client->request(
                self::HTTP_GET,
                $exchangeRateApiUrl,
                self::PARAMS
            );
            var_dump($response->getContent());
            die;
        } catch (TransportExceptionInterface
        | ClientExceptionInterface
        | RedirectionExceptionInterface
        | ServerExceptionInterface $e) {
            var_dump($e);
            die;
        }
    }
}