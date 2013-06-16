<?php
namespace Dlin\Saasu\Entity;
class InventoryAdjustmentItem extends EntityBase
{
    public function __construct($uid=null){
        parent::__construct($uid);
    }

    public $quantity;

    public $inventoryItemUid;

    public $accountUid;

    public $unitPriceExclTax;

    public $totalPriceExclTax;
}
