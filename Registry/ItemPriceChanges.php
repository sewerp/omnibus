<?php

namespace Registry;

use Entity\ItemInterface;
use Entity\MonetaryInterface;


class ItemPriceChanges extends BaseRegistryChanges
{
    /**
     * @param ItemInterface $itemBeingSaved
     * @return true|void
     * @throws \Exception
     */
    public function registryUpdate(ItemInterface $itemBeingSaved)
    {
        $itemInDb = $this->itemsModel->getById($itemBeingSaved->getId());

        if (!$itemInDb) {
            throw new \Exception("Missing Item in db when registering price change");
        }

        if ($itemInDb->getPrice() <= $itemBeingSaved->getPrice()) {
            return true;
        }

        //get today's entries for this item for all currencies
        $todayPriceChanges = $this->priceChangesModel->getTodaysByItemId($itemBeingSaved->getId());
        $currencies        = $this->currenciesModel->getAll();
        $discountGroups    = $this->discountGroupsModel->getAll();

        foreach ($todayPriceChanges as $todayPriceChange) {
            $price = $this->itemPricesHelper->calculatePrice(
                $itemBeingSaved->getPrice(),
                $currencies[$todayPriceChange->getCurrencyId()]->getFactor(),
                $discountGroups[$todayPriceChange->getDiscountGroupId()]->getDiscountPercent()
            );

            $todayPriceChange->setPrice($price);
            $this->priceChangesModel->save($todayPriceChange);
        }
    }
}