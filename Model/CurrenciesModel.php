<?php

namespace Model;

use Entity\EntityInterface;
use Registry\CurrencyFactorChanges;

class CurrenciesModel extends Model
{
    const TABLE_NAME = "currencies";

    /**
     * @param EntityInterface $entity
     * @return bool|void
     */
    public function update(EntityInterface $entity)
    {
        //create registry of factor change before save to db
        $currencyFactorChangesRegistry = new CurrencyFactorChanges();
        $currencyFactorChangesRegistry->registryUpdate($entity);

        parent::update($entity);
    }

    //TODO when adding a new currency it also needs to create PriceChanges registry entries
}