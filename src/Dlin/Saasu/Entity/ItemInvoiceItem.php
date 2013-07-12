<?php
namespace Dlin\Saasu\Entity;

use Dlin\Saasu\Validator\Validator;

class ItemInvoiceItem extends EntityBase
{
    public function __construct($uid=null){
        parent::__construct($uid);
    }


    public $quantity;
    public $inventoryItemUid;
    public $description;
    public $taxCode;
    public $unitPriceInclTax;

    public $totalAmountInclTax;

    public $totalAmountExclTax;

    public $totalTaxAmount;
    public $percentageDiscount;
    public $tags;

    public function validate()
    {


        return Validator::instance()->
            lookAt($this->quantity, 'quantity')->numeric()->required(true)->
            lookAt($this->inventoryItemUid, 'inventoryItemUid')->int()->required(true)->
            lookAt($this->unitPriceInclTax, 'unitPriceInclTax')->numeric()->required(true)->
            lookAt($this->totalAmountInclTax, 'totalAmountInclTax')->numeric()->
            lookAt($this->totalAmountExclTax, 'totalAmountExclTax')->numeric()->
            lookAt($this->totalTaxAmount, 'totalTaxAmount')->numeric()->
            lookAt($this->percentageDiscount, 'percentageDiscount')->numeric();

    }
}
