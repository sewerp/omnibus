<?php

use Entity\Currency;
use Entity\DiscountGroup;
use Model\CurrenciesModel;
use Model\ItemsModel;
use Model\DiscountGroupsModel;
use Controller\ItemsController;
use Controller\CurrenciesController;
use Helper\ItemPrices;
use Entity\Item;

spl_autoload_register(function ($class_name) {
    $class_name = str_replace('\\', "/", $class_name);
    include $class_name . '.php';
});

//Test parameters
$itemId          = 1;
$itemPrice       = 4;
$currencyId      = 2;
$discountGroupId = 1;
$currencyFactor  = 3.9;

$currenciesModel     = new CurrenciesModel(new Currency());
$itemsModel          = new ItemsModel(new Item());
$discountGroupsModel = new DiscountGroupsModel(new DiscountGroup());
$itemPricesHelper    = new ItemPrices();
$currency            = $currenciesModel->getById($currencyId);
$discountGroup       = $discountGroupsModel->getById($discountGroupId);


//Update item and check if lowest item price is changed
$itemsController = new ItemsController();
list($item) = $itemsController->update($itemId, $itemPrice);

printf("[Item price is now %sPLN]\n", $item->getPrice());
printf(
    "[Lowest price for " . $discountGroup->getTitle() . " group is %s " . $currency->getSymbol() . "]\n",
    $itemPricesHelper->get30DaysLowestPrice($item, $currencyId, $discountGroupId)
);

//Update Currency and check if lowest item price is changed
$currenciesController = new CurrenciesController();
list($currency) = $currenciesController->update($currencyId, $currencyFactor);

$item = $itemsModel->getById($itemId);

printf("[Item price is now %sPLN]\n", $item->getPrice());
printf(
    "[Lowest price for " . $discountGroup->getTitle() . " group is %s " . $currency->getSymbol() . "]\n",
    $itemPricesHelper->get30DaysLowestPrice($item, $currencyId, $discountGroupId)
);