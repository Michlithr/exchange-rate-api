<?php


namespace App\Serializer;


use App\Entity\ExchangeRate;

class ExchangeRateSerializer
{
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