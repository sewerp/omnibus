<?php

namespace Controller;

use Entity\Currency;
use Entity\DiscountGroup;
use Entity\Item;
use Model\CurrenciesModel;
use Model\DiscountGroupsModel;
use Model\ItemsModel;
use \Helper\ItemPrices;

class ItemsController
{
    /**
     * @return array
     */
    public function showAll(): array
    {
        $itemsModel          = new ItemsModel(new Item());
        $itemPricesHelper    = new ItemPrices();
        $discountGroupsModel = new DiscountGroupsModel(new DiscountGroup());
        $currenciesModel     = new CurrenciesModel(new Currency());
        $currencies          = $currenciesModel->getAll();
        $discountGroups      = $discountGroupsModel->getAll();
        $items               = $itemsModel->getAll();

        return [$items, $itemPricesHelper, $discountGroups, $currencies];
    }

    /**
     * @param int $id
     * @param float $price
     * @return array
     * @throws \Exception
     */
    public function update(int $id, float $price): array
    {
        $itemsModel = new ItemsModel(new Item());
        $item       = $itemsModel->getById($id);

        if (!$item) {
            throw new \Exception("Item with id $id does not exist");
        }

        $item->setPrice($price);

        //Save will trigger PriceChangesRegistry update
        $itemsModel->save($item);

        return [$item];
    }
}