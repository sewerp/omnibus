<?php

namespace Entity;

abstract class Monetary extends Entity implements MonetaryInterface
{
    protected $price;

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return void
     */
    public function setPrice(float $price)
    {
        $this->price = bcmul($price, 1, 2);
    }
}