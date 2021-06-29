<?php


namespace App\Serializer;


use App\Entity\ExchangeRate;

/**
 * Class ExchangeRateSerializer
 * @package App\Serializer
 */
class ExchangeRateSerializer
{
    /**
     * Method returns object represented by json
     *
     * @param ExchangeRate $exchangeRate
     * @return string
     */
    public function serialize(ExchangeRate $exchangeRate): string
    {
        $exchangeRateArray = [
            'fromCode' => $exchangeRate->getFromCode(),
            'toCode' => $exchangeRate->getToCode(),
            'rate' => $exchangeRate->getRate(),
            'date' => $exchangeRate->getDate()
        ];

        return json_encode($exchangeRateArray);
    }
}