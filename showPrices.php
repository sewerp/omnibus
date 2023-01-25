<?php

spl_autoload_register(function ($class_name) {
    $class_name = str_replace('\\', "/", $class_name);
    include $class_name . '.php';
});


//This command needs to run once every day at 00:01
$priceRegistryCommand = new \Commands\PriceRegistryCommand();
$priceRegistryCommand->execute(true);


$itemsController      = new Controller\ItemsController();
$currenciesController = new Controller\CurrenciesController();

//FOR TESTING


//$itemsController->update(11, 15);
//$currenciesController->update(2, 4.8);


//Example of showing the smallest price within 30 days
list($items, $itemPricesHelper, $discountGroups, $currencies) = $itemsController->showAll();

$userDiscountGroupId = 1;
$currencyId          = 1;

foreach ($items as $item) {
    $lowestPrice = $itemPricesHelper->get30DaysLowestPrice($item, $currencyId, $userDiscountGroupId);
    printf("[lowest Price for " . $item->getTitle(). " is %s]\n", $lowestPrice);
}


//
//
//foreach ($items as $item) {
//    foreach ($discountGroups as $discountGroup) {
//        foreach ($currencies as $currency) {
//            printf(
//                "[%s]\n",
//                $item->getTitle() . " " .
//                $discountGroup->getTitle() . " " . $discountGroup->getDiscountPercent() . "% " .
//                $currency->getSymbol() .
//                $itemPricesHelper->get30DaysLowestPrice(
//                    $item, $currency->getId(), $discountGroup->getId()
//                )
//            );
//        }
//    }
//}
//
//

