<?php

namespace Commands;

use Entity\Currency;
use Entity\DiscountGroup;
use Entity\Item;
use Helper\ItemPrices;
use Entity\PriceChange;
use Model\CurrenciesModel;
use Model\DiscountGroupsModel;
use Model\ItemsModel;
use Model\PriceChangesModel;

class PriceRegistryCommand
{
    /**
     * @var PriceChangesModel
     */
    protected $priceChangesModel;
    /**
     * @var ItemsModel
     */
    protected $itemsModel;
    /**
     * @var CurrenciesModel
     */
    protected $currenciesModel;
    /**
     * @var DiscountGroupsModel
     */
    protected $discountGroupsModel;
    /**
     * @var ItemPrices
     */
    protected $itemPricesHelper;

    public function __construct()
    {
        $this->priceChangesModel   = new PriceChangesModel(new PriceChange());
        $this->itemsModel          = new ItemsModel(new Item());
        $this->currenciesModel     = new CurrenciesModel(new Currency());
        $this->discountGroupsModel = new DiscountGroupsModel(new DiscountGroup());
        $this->itemPricesHelper    = new ItemPrices();
    }

    /**
     * @param bool $force
     * @return bool
     * @throws \Exception
     */
    public function execute(bool $force = false): bool
    {
        //check if it did run
        if ($this->priceChangesModel->getAllTodaysEntries() && !$force) {
            throw new \Exception("command did run today so no need to rerun it. ");
        }

        //Remove old Data
        $this->priceChangesModel->deleteEntriesOlderThan30Days();

        $items          = $this->itemsModel->getAll();
        $currencies     = $this->currenciesModel->getAll();
        $discountGroups = $this->discountGroupsModel->getAll();

        //Insert current prices for all currencies
        foreach ($items as $item) {
            foreach ($currencies as $currency) {
                foreach ($discountGroups as $discountGroup) {
                    $priceChange = $this->priceChangesModel->getEntity();
                    $price       = $this->itemPricesHelper->calculatePrice(
                        $item->getPrice(),
                        $currency->getFactor(),
                        $discountGroup->getDiscountPercent()
                    );

                    $priceChange->setItemId($item->getId());
                    $priceChange->setCurrencyId($currency->getId());
                    $priceChange->setPrice($price);
                    $priceChange->setDiscountGroupId($discountGroup->getId());

                    $this->priceChangesModel->save($priceChange);
                }
            }
        }

        return true;
    }
}