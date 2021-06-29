<?php


namespace App\Service;


use App\Entity\ExchangeRate;
use App\Model\NBPRateExchangeModel;
use App\Repository\ExchangeRateRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
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

//    private HttpClientInterface $client;
//    private

    public function __construct(private HttpClientInterface $client,
                                private ExchangeRateRepository $exchangeRateRepository) {}

    /**
     * The method returns the $currencyCode/PLN exchange rate for $date and adds it to the database, if it is not
     * already there (for historical data purposes)
     *
     * @param string $currencyCode EUR by default
     * @param string $date today by default
     *
     * @return string
     * @throws Exception
     */
    public function getExchangeRate(string $currencyCode, string $date, ObjectManager $entityManager): string
    {
        try {
            $this->validateParams($currencyCode, $date);
            $exchangeRate = $this->fetchExchangeRate($currencyCode, $date);

            $this->addNewExchangeRateRecord($exchangeRate, $entityManager);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Methods validates query params
     *
     * @param string $currencyCode EUR by default
     * @param string $date today by default
     *
     * @throws Exception
     */
    private function validateParams(string $currencyCode, string $date): void
    {
        if (strlen($currencyCode) != self::CURRENCY_CODE_LENGTH)
            throw new Exception('Bad country code format. Please provide 3 letters code.');

        if ($date && $date !== self::DEFAULT_DATE_PARAM) {
            $dateTime = DateTime::createFromFormat("Y-m-d", $date);
            if ($dateTime === false || array_sum($dateTime::getLastErrors()))
                throw new Exception('Bad date format. Please provide YYYY-MM-DD date.');
        }
    }

    /**
     * Method fetches exchange rate for currencyCode/PLN from date
     *
     * @param string $currencyCode EUR by default
     * @param string $date today by default
     *
     * @return NBPRateExchangeModel
     * @throws Exception
     */
    private function fetchExchangeRate(string $currencyCode, string $date): NBPRateExchangeModel
    {
        $exchangeRateApiUrl = self::NBP_API_URL . $currencyCode . '/' . $date;

        try {
            $response = $this->client->request(
                self::HTTP_GET,
                $exchangeRateApiUrl,
                self::PARAMS
            );

            return new NBPRateExchangeModel(json_decode($response->getContent()));
        } catch (TransportExceptionInterface
        | ClientExceptionInterface
        | RedirectionExceptionInterface
        | ServerExceptionInterface $e) {
            throw new Exception('Something went wrong with fetching currency exchange rate.');
        }
    }

    /**
     * Methods adds exchange rate to db if it already doesn't exist
     *
     * @param NBPRateExchangeModel $exchangeRate
     * @param ObjectManager $entityManager
     */
    private function addNewExchangeRateRecord(NBPRateExchangeModel $nbpExchangeRate, ObjectManager $entityManager)
    {
        $existingExchangeRate = $this->exchangeRateRepository->findOneBy([
            'fromCode' => $nbpExchangeRate->getCode(),
            'date' => $nbpExchangeRate->getRate()->getEffectiveDate()
        ]);

        if ($existingExchangeRate)
            return;

        $exchangeRate = new ExchangeRate();
        $exchangeRate->setFromCode($nbpExchangeRate->getCode());
        $exchangeRate->setToCode('PLN');
        $exchangeRate->setDate($nbpExchangeRate->getRate()->getEffectiveDate());
        $exchangeRate->setRate($nbpExchangeRate->getRate()->getMid());


        var_dump($existingExchangeRate);die;
    }
}