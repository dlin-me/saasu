<?php
namespace Dlin\Saasu\Entity;

use Dlin\Saasu\Validator\Validator;

class InventoryAdjustmentItem extends EntityBase
{
    public function __construct($uid=null){
        parent::__construct($uid);
        $this->_entityName = "item";
    }

    public $quantity;

    public $inventoryItemUid;

    public $accountUid;

    public $unitPriceExclTax;

    public $totalPriceExclTax;

    public function validate(){

        return Validator::instance()->
            lookAt($this->quantity, 'quantity')->numeric()->
            lookAt($this->inventoryItemUid, 'inventoryItemUid')->int()->
            lookAt($this->accountUid, 'accountUid')->int()->
            lookAt($this->unitPriceExclTax, 'unitPriceExclTax')->numeric()->
            lookAt($this->totalPriceExclTax, 'totalPriceExclTax')->numeric();
    }
}
