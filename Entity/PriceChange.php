<?php

namespace Entity;

class PriceChange extends Monetary
{
    protected $itemId;
    protected $currencyId;
    protected $discountGroupId;
    protected $createdAt;

    public function __construct()
    {
        $this->setCreatedAt(date("Y-m-d H:i:s"));
    }

    /**
     * @return int
     */
    public function getItemId(): int
    {
        return $this->itemId;
    }

    /**
     * @param int $itemId
     * @return void
     */
    public function setItemId(int $itemId)
    {
        $this->itemId = $itemId;
    }

    /**
     * @return int
     */
    public function getCurrencyId(): int
    {
        return $this->currencyId;
    }

    /**
     * @param int $currencyId
     * @return void
     */
    public function setCurrencyId(int $currencyId)
    {
        $this->currencyId = $currencyId;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     * @return void
     */
    public function setCreatedAt(string $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getDiscountGroupId(): int
    {
        return $this->discountGroupId;
    }

    /**
     * @param int $discountGroupId
     * @return void
     */
    public function setDiscountGroupId(int $discountGroupId)
    {
        $this->discountGroupId = $discountGroupId;
    }
}