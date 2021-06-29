<?php


namespace App\Model;


use JetBrains\PhpStorm\Pure;

/**
 * Class NBPRateExchangeModel
 * @package App\Model
 */
class NBPRateExchangeModel
{
    /**
     * @var string
     */
    private string $table;
    /**
     * @var string
     */
    private string $currency;
    /**
     * @var string
     */
    private string $code;
    /**
     * @var NBPRateModel
     */
    private NBPRateModel $rate;


    /**
     * NBPRateExchangeModel constructor.
     * @param mixed $nbpExchangeRateJson
     */
    #[Pure] public function __construct(mixed $nbpExchangeRateJson)
    {
        foreach ($nbpExchangeRateJson AS $key => $value) {
            if ($key !== 'rates')
                $this->{$key} = $value;
            else if ($nbpExchangeRateJson->rates)
                $this->rate = new NBPRateModel($nbpExchangeRateJson->rates);
        }
    }


    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @param string $table
     */
    public function setTable(string $table): void
    {
        $this->table = $table;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return NBPRateModel
     */
    public function getRate(): NBPRateModel
    {
        return $this->rate;
    }

    /**
     * @param NBPRateModel $rate
     */
    public function setRate(NBPRateModel $rate): void
    {
        $this->rate = $rate;
    }
}