<?php
namespace Dlin\Saasu\Entity;

class ItemInvoiceItem
{
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
