<?php

namespace Entity;

abstract class Entity implements EntityInterface
{
    protected $id;

    /**
     * @param array $array
     * @return mixed|void
     */
    public function setFromArray(array $array)
    {
        foreach ($array as $key => $value) {
            if (!isset($this->$key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * @return array
     */
    public function getArray(): array
    {
        $returnArray = [];

        foreach ($this as $key => $value) {
            if (is_numeric($key)) {
                continue;
            }
            $returnArray[$key] = $value;
        }

        return $returnArray;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return void
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }
}