<?php

namespace Controller;

use Entity\Currency;
use Entity\DiscountGroup;
use Entity\Item;
use Model\CurrenciesModel;
use Model\DiscountGroupsModel;
use Model\ItemsModel;
use \Helper\ItemPrices;

class CurrenciesController
{
    /**
     * @return array
     */
    public function showAll(): array
    {
        $currenciesModel = new CurrenciesModel(new Currency());
        $currencies      = $currenciesModel->getAll();

        return [$currencies];
    }

    /**
     * @param int $id
     * @param float $factor
     * @return array
     * @throws \Exception
     */
    public function update(int $id, float $factor)
    {
        $currenciesModel = new CurrenciesModel(new Currency());
        $currency        = $currenciesModel->getById($id);

        if (!$currency) {
            throw new \Exception("Item with id $id does not exist");
        }

        $currency->setFactor($factor);

        //Save will trigger PriceChangesRegistry update
        $currenciesModel->save($currency);

        return [$currency];
    }
}