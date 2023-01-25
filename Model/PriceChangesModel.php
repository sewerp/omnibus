<?php

namespace Model;

class PriceChangesModel extends Model
{
    const TABLE_NAME = "priceChanges";

    /**
     * @param int $itemId
     * @param $createdAt
     * @return \Entity\Entity|null
     */
    public function getByItemIdForToday(int $itemId)
    {
        $sql       = "SELECT * FROM " . static::TABLE_NAME . " WHERE itemId = :itemId AND createdAt = :createdAt";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':itemId', $itemId);
        $statement->bindValue(':createdAt', date("Y-m-d"));
        $statement->execute();

        return $this->populateEntities($statement);
    }

    /**
     * @param int $itemId
     * @param int $currencyId
     * @param int $discountGroupId
     * @return string
     * @throws \Exception
     */
    public function getMinByItemIdAndCurrencyIdAndDiscountGroupId(int $itemId, int $currencyId, int $discountGroupId)
    {
        $sql       = "SELECT MIN(price) as minimumPrice
                      FROM " . static::TABLE_NAME . " 
                      WHERE itemId = :itemId AND currencyId = :currencyId AND discountGroupId = :discountGroupId";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':itemId', $itemId);
        $statement->bindValue(':currencyId', $currencyId);
        $statement->bindValue(':discountGroupId', $discountGroupId);
        $statement->execute();
        $result = $statement->fetch();

        if (empty($result["minimumPrice"])) {
            throw new \Exception("No Results for itemId=$itemId, currencyId=$currencyId, discountGroupId=$discountGroupId");
        }

        return bcmul($result["minimumPrice"], 1, 2);
    }

    /**
     * @param int $itemId
     * @param $createdAt
     * @return \Entity\Entity|null
     */
    public function deleteEntriesOlderThan30Days()
    {
        $sql       = "DELETE FROM " . static::TABLE_NAME . " WHERE DATE(createdAt) < :createdAt";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':createdAt', date("Y-m-d", strtotime("-30 days")));
        return $statement->execute();
    }

    /**
     * @param int $itemId
     * @return \Entity\Entity|null
     */
    public function getAllTodaysEntries()
    {
        $sql       = "SELECT * FROM " . static::TABLE_NAME . " WHERE createdAt = :createdAt";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':createdAt', date("Y-m-d"));
        $statement->execute();

        return $this->populateEntities($statement);
    }

    /**
     * @param int $itemId
     * @return \Entity\Entity|null
     */
    public function getTodaysEntriesByCurrencyId(int $currencyId)
    {
        $sql       = "SELECT * FROM " . static::TABLE_NAME . " WHERE currencyId = :currencyId AND createdAt = :createdAt";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':currencyId', $currencyId);
        $statement->bindValue(':createdAt', date("Y-m-d"));
        $statement->execute();

        return $this->populateEntities($statement);
    }


}