<?php
namespace Dlin\Saasu\Entity;
class InventoryTransferItem extends EntityBase
{
    public function __construct($uid=null){
        parent::__construct($uid);
    }

    public $quantity;

    public $inventoryItemUid;

    public $unitPriceExclTax;

    public $totalPriceExclTax;
}
