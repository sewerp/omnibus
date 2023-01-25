<?php

namespace Entity;

interface MonetaryInterface
{
    /**
     * @return float
     */
    public function getPrice(): float;

    /**
     * @param float $price
     * @return mixed
     */
    public function setPrice(float $price);
}