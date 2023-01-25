<?php

namespace Registry;

use Entity\Currency;
use Entity\DiscountGroup;
use Entity\Item;
use Entity\PriceChange;
use Helper\ItemPrices;
use Model\CurrenciesModel;
use Model\DiscountGroupsModel;
use Model\ItemsModel;
use Model\PriceChangesModel;

abstract class BaseRegistryChanges
{
    protected $itemsModel;
    protected $priceChangesModel;
    protected $currenciesModel;
    protected $itemPricesHelper;
    protected $discountGroupsModel;

    public function __construct()
    {
        $this->itemsModel          = new ItemsModel(new Item());
        $this->priceChangesModel   = new PriceChangesModel(new PriceChange());
        $this->currenciesModel     = new CurrenciesModel(new Currency());
        $this->discountGroupsModel = new DiscountGroupsModel(new DiscountGroup());
        $this->itemPricesHelper    = new ItemPrices();
    }
}