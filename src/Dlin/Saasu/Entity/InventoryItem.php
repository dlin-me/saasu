<?php
namespace Dlin\Saasu\Entity;

use Dlin\Saasu\Validator\Validator;

class InventoryItem extends EntityBase
{
    public function __construct($uid = null)
    {
        parent::__construct($uid);
    }


    public $code;
    public $description;
    public $isActive;
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

    /**
     * @param bool $forUpdate
     * @return Validator
     */
    public function validate($forUpdate = false)
    {

        return Validator::instance()->
            lookAt($this->uid, 'uid')->required($forUpdate)->int()->
            lookAt($this->lastUpdatedUid, 'lastUpdatedUid')->required($forUpdate)->int()->
            lookAt($this->code, 'code')->required(true)->length(1, 32)->
            lookAt($this->description, 'description')->required(true)->length(1, 4000)->
            lookAt($this->isActive, 'isActive')->bool()->
            lookAt($this->isInventoried, 'isInventoried')->bool()->
            lookAt($this->assetAccountUid, 'assetAccountUid')->int()->
            lookAt($this->stockOnHand, 'stockOnHand')->numeric()->
            lookAt($this->currentValue, 'currentValue')->numeric()->
            lookAt($this->isBought, 'isBought')->bool()->
            lookAt($this->purchaseExpenseAccountUid, 'purchaseExpenseAccountUid')->int()->
            lookAt($this->minimumStockLevel, 'minimumStockLevel')->numeric()->
            lookAt($this->primarySupplierContactUid, 'primarySupplierContactUid')->int()->
            lookAt($this->primarySupplierItemCode, 'primarySupplierItemCode')->length(0, 32)->
            lookAt($this->defaultReOrderQuantity, 'defaultReOrderQuantity')->numeric()->
            lookAt($this->buyingPrice, 'buyingPrice')->numeric()->
            lookAt($this->isBuyingPriceIncTax, 'isBuyingPriceIncTax')->bool()->
            lookAt($this->isSold, 'isSold')->bool()->
            lookAt($this->saleIncomeAccountUid, 'saleIncomeAccountUid')->int()->
            lookAt($this->saleCoSAccountUid, 'saleCoSAccountUid')->int()->
            lookAt($this->sellingPrice, 'sellingPrice')->numeric()->
            lookAt($this->isSellingPriceIncTax, 'isSellingPriceIncTax')->bool()->
            lookAt($this->isVirtual, 'isVirtual')->bool()->
            lookAt($this->isVisible, 'isVisible')->bool()->
            lookAt($this->isVoucher, 'isVoucher')->bool()->
            lookAt($this->validFrom, 'validFrom')->date()->
            lookAt($this->validTo, 'validTo')->date();

    }


}
