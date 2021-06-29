<?php

namespace App\Entity;

use App\Repository\ExchangeRateRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExchangeRateRepository::class)
 */
class ExchangeRate
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private string $fromCode;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private string $toCode;

    /**
     * @ORM\Column(type="float")
     */
    private float $rate;

    /**
     * @ORM\Column(type="string")
     */
    private string $date;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getFromCode(): ?string
    {
        return $this->fromCode;
    }

    /**
     * @param string $fromCode
     * @return $this
     */
    public function setFromCode(string $fromCode): self
    {
        $this->fromCode = $fromCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getToCode(): ?string
    {
        return $this->toCode;
    }

    /**
     * @param string $toCode
     * @return $this
     */
    public function setToCode(string $toCode): self
    {
        $this->toCode = $toCode;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getRate(): ?float
    {
        return $this->rate;
    }

    /**
     * @param float $rate
     * @return $this
     */
    public function setRate(float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @param string $date
     * @return $this
     */
    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }
}
