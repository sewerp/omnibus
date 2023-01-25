<?php

namespace Model;

use Entity\Entity;
use Entity\EntityInterface;

class Model
{
    const TABLE_NAME = "items";
    protected $entity;
    /**
     * @var $connection
     */
    protected $connection;

    /**
     * @param Entity $entity
     */
    public function __construct(Entity $entity)
    {
        try {
//            $this->connection = new \mysqli("localhost", 'trol', 'trol', 'trol');
            $this->connection = new \PDO("mysql:host=localhost;dbname=trol", 'trol', 'trol');

            if (empty($this->connection)) {
                throw new \PDOException("Connection to db failed");
            }
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }



        $this->entity = $entity;
    }

    /**
     * @param EntityInterface $entity
     * @return bool|string|null
     */
    public function save(EntityInterface $entity)
    {
        if ($entity->getId() > 0) {
            return $this->update($entity);
        }

        return $this->create($entity);
    }

    /**
     * @param EntityInterface $entity
     * @return false|string
     */
    public function create(EntityInterface $entity)
    {
        $array1    = $entity->getArray();
        $array     = $this->filterArrayForSave($array1);
        $arrayKeys = array_keys($array);
        $keys      = implode(', ', $arrayKeys);
        $binds     = ":" . implode(', :', $arrayKeys);
        $sql       = "INSERT INTO " . static::TABLE_NAME . " ({$keys}) VALUES ($binds)";
        $stmt      = $this->connection->prepare($sql);
        foreach ($array as $property => $value) {
            $stmt->bindValue(":$property", $value);
        }
        $stmt->execute();

        $id = $this->connection->lastInsertId();
        $entity->setId($id);

        return $id;
    }

    /**
     * @param EntityInterface $entity
     * @return bool|void
     */
    public function update(EntityInterface $entity)
    {
        $array  = $entity->getArray();
        $array  = $this->filterArrayForSave($array);
        $fields = '';

        foreach ($array as $property => $value) {
            $fields .= empty($fields) ? "$property = :$property" : ", $property = :$property";
        }
        if (empty($fields)) {
            return;
        }
        $sql  = "UPDATE " . static::TABLE_NAME . " SET {$fields} WHERE id = :id";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":id", $entity->getId());

        foreach ($array as $property => $value) {
            $stmt->bindValue(":$property", $value);
        }

        return $stmt->execute();
    }

    protected function filterArrayForSave($array)
    {
        array_filter($array, function ($k) {
            return $k !== null;
        });

        return $array;
    }

    /**
     * @param int $id
     * @return EntityInterface
     */
    public function getById(int $id)
    {
        $sql  = "SELECT * FROM " . static::TABLE_NAME . " WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();

        return $this->populateEntity($statement);
    }

    public function getAll()
    {
        $sql    = "SELECT * FROM " . static::TABLE_NAME;
        $statement = $this->connection->prepare($sql);
        $statement->execute();

        return $this->populateEntities($statement);
    }

    public function populateEntities($statement)
    {
        $return = [];

        while ($row = $statement->fetch()) {
            if (empty($row["id"])) {
                continue;
            }
            $entity = clone $this->entity;
            $entity->setFromArray($row);
            $return[$entity->getId()] = $entity;
        }

        return $return;
    }


    /**
     * @param $statement
     * @return Entity|null
     */
    public function populateEntity($statement)
    {
        $row = $statement->fetch();

        if (!empty($row)) {
            $entity = clone $this->entity;
            $entity->setFromArray($row);

            return $entity;
        }

        return null;
    }

    /**
     * @return Entity
     */
    public function getEntity()
    {
        return clone $this->entity;
    }
}