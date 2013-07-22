<?php
namespace Dlin\Saasu\Entity;

use Dlin\Saasu\Validator\Validator;

class InventoryTransferItem extends EntityBase
{
    public function __construct($uid = null)
    {
        parent::__construct($uid);
        $this->_entityName = 'item';
    }

    public $quantity;

    public $inventoryItemUid;

    public $unitPriceExclTax;

    public $totalPriceExclTax;

    public function validate()
    {

        return Validator::instance()->
            lookAt($this->quantity, 'quantity')->required(true)->numeric()->
            lookAt($this->inventoryItemUid, 'inventoryItemUid')->required(true)->int()->
            lookAt($this->unitPriceExclTax, 'unitPriceExclTax')->required(true)->numeric()->
            lookAt($this->totalPriceExclTax, 'totalPriceExclTax')->required(true)->numeric();
    }
}
