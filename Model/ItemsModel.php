<?php

namespace Model;

use Entity\EntityInterface;
use Registry\ItemPriceChanges;

class ItemsModel extends Model
{
    const TABLE_NAME = "items";

    /**
     * @param EntityInterface $entity
     * @return bool|void
     * @throws \Exception
     */
    public function update(EntityInterface $entity)
    {
        //create registry of price change before save to db
        $itemPriceChangesRegistry = new ItemPriceChanges();
        $itemPriceChangesRegistry->registryUpdate($entity);

        parent::update($entity);
    }

    //TODO when adding an item it also needs to create PriceChanges registry entries
}