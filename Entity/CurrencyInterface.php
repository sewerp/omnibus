<?php

namespace Entity;

interface CurrencyInterface extends EntityInterface
{
    /**
     * @return float
     */
    public function getFactor(): float;

}