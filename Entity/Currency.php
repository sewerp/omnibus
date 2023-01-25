<?php

namespace Entity;

class Currency extends Entity implements CurrencyInterface
{
    protected $symbol;
    protected $factor;

    /**
     * @return mixed
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }

    /**
     * @param string $symbol
     * @return void
     */
    public function setSymbol(string $symbol)
    {
        $this->symbol = $symbol;
    }

    /**
     * @return float
     */
    public function getFactor(): float
    {
        return $this->factor;
    }

    /**
     * @param float $factor
     */
    public function setFactor(float $factor)
    {
        $this->factor = $factor;
    }
}