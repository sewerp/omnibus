<?php

namespace Helper;

use Entity\PriceChange;
use Model\PriceChangesModel;

class ItemPrices
{
    /**
     * @param float $price
     * @param float $factor
     * @param int $discountPercent
     * @return float
     */
    public function calculatePrice(float $price, float $factor, int $discountPercent): float
    {
        return bcmul(bcdiv($price, $factor, 2), (100 - $discountPercent) / 100, 2);
    }

    /**
     * @param $item
     * @param $currencyId
     * @param $discountGroupId
     * @return float
     * @throws \Exception
     */
    public function get30DaysLowestPrice($item, $currencyId, $discountGroupId): float
    {
        $pricesChangesModel = new PriceChangesModel(new PriceChange());

        return $pricesChangesModel->getMinByItemIdAndCurrencyIdAndDiscountGroupId(
            $item->getId(), $currencyId, $discountGroupId
        );
    }
}