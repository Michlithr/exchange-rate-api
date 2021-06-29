<?php


namespace App\Model;


/**
 * Class NBPRateModel
 * @package App\Model
 */
class NBPRateModel
{
    /**
     * @var string
     */
    private string $no;
    /**
     * @var string
     */
    private string $effectiveDate;
    /**
     * @var float
     */
    private float $mid;


    /**
     * NBPRateModel constructor.
     * @param array $nbpRatesJson
     */
    public function __construct(array $nbpRatesJson)
    {
        if (sizeof($nbpRatesJson)) {
            foreach ($nbpRatesJson[0] as $key => $value)
                $this->{$key} = $value;
        }
    }


    /**
     * @return string
     */
    public function getNo(): string
    {
        return $this->no;
    }

    /**
     * @param string $no
     */
    public function setNo(string $no): void
    {
        $this->no = $no;
    }

    /**
     * @return string
     */
    public function getEffectiveDate(): string
    {
        return $this->effectiveDate;
    }

    /**
     * @param string $effectiveDate
     */
    public function setEffectiveDate(string $effectiveDate): void
    {
        $this->effectiveDate = $effectiveDate;
    }

    /**
     * @return float
     */
    public function getMid(): float
    {
        return $this->mid;
    }

    /**
     * @param float $mid
     */
    public function setMid(float $mid): void
    {
        $this->mid = $mid;
    }
}