<?php
namespace Dlin\Saasu\Entity;

class InventoryItem extends EntityBase
{
    public $code;
    public $description;
    public $isActive = true;
    public $notes;
    public $isInventoried;
    public $assetAccountUid;
    public $stockOnHand;
    public $currentValue;
    public $quantityOnOrder;
    public $quantityCommitted;
    public $isBought;
    public $purchaseExpenseAccountUid;
    public $purchaseTaxCode;
    public $minimumStockLevel;
    public $primarySupplierContactUid;
    public $primarySupplierItemCode;
    public $defaultReOrderQuantity;
    public $isSold;
    public $saleIncomeAccountUid;
    public $saleTaxCode;
    public $saleCoSAccountUid;
// <summary>
// Deprecated. Don't use this. Use "SellingPrice" and "IsSellingPriceIncTax" instead.
// </summary>
    public $rrpInclTax;
    public $sellingPrice;
    public $isSellingPriceIncTax;
    public $buyingPrice;
    public $isBuyingPriceIncTax;
    public $isVoucher;
    public $validFrom;
    public $validTo;
    public $isVirtual;
    public $vType;
    public $isVisible;
}
