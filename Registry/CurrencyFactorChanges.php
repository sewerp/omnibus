<?php

namespace Registry;

use Entity\CurrencyInterface;

class CurrencyFactorChanges extends BaseRegistryChanges
{
    public function registryUpdate(CurrencyInterface $currencyBeingSaved)
    {
        $currencyInDb = $this->currenciesModel->getById($currencyBeingSaved->getId());

        if (!$currencyInDb) {
            throw new \Exception("Missing Currency in db when registering factor change");
        }

        $previousFactor = $currencyInDb->getFactor();
        $newFactor      = $currencyBeingSaved->getFactor();

        //If currency factor increased then do nothing because command already created lower price in the morning
        if ($previousFactor <= $newFactor) {
            return true;
        }

        // Get Today's Changes and update price for all items
        $todayPriceRegistries = $this->priceChangesModel->getTodaysEntriesByCurrencyId($currencyBeingSaved->getId());

        foreach ($todayPriceRegistries as $todayPriceRegistry) {
            //update price for item using proportion
            $previousPrice = $todayPriceRegistry->getPrice();
            $newPrice      = bcdiv(bcmul($previousPrice, $newFactor, 4), $previousFactor, 2);
            $todayPriceRegistry->setPrice($newPrice);

            $this->priceChangesModel->save($todayPriceRegistry);
        }

        return true;
    }
}