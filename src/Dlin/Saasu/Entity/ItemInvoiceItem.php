<?php
namespace Dlin\Saasu\Entity;

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
}
