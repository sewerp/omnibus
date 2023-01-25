<?php

namespace Entity;

interface EntityInterface
{
    /**
     * @return int|null
     */
    public function getId();

    /**
     * @param array $array
     * @return mixed
     */
    public function setFromArray(array $array);

    /**
     * @return array
     */
    public function getArray(): array;
}