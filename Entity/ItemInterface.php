<?php

namespace Entity;

interface ItemInterface extends MonetaryInterface, EntityInterface
{
    /**
     * @return string
     */
    public function getTitle(): string;

}