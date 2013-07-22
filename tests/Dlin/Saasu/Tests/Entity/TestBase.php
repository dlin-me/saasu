<?php

namespace Dlin\Saasu\Tests\Entity;
use Dlin\Saasu\Criteria\BankAccountCriteria;
use Dlin\Saasu\Criteria\FullComboItemCriteria;
use Dlin\Saasu\Criteria\FullInventoryItemCriteria;
use Dlin\Saasu\Entity\BankAccount;
use Dlin\Saasu\Entity\ComboItem;
use Dlin\Saasu\Entity\InventoryItem;
use Dlin\Saasu\Enum\TaxCode;
use Dlin\Saasu\SaasuAPI;
use Dlin\Saasu\Util\DateTime;


/**
 *
 * User: davidlin
 * Date: 21/05/13
 * Time: 12:04 AM
 *
 */


class TestBase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Dlin\Saasu\SaasuAPI $api
     */
    protected $api;

    public function setUp()
    {
        $this->api = new SaasuAPI('0933A2A7616C4DED82EF3E02A3B18A9E', '41509');
    }



    protected function removeTestBankAccounts(){
        $accountCriteria = new BankAccountCriteria();
        $accountCriteria->isInbuilt = 'false';
        $accounts = $this->api->searchEntities($accountCriteria);

        foreach($accounts as $account){
            $this->api->deleteEntity($account);
        }

    }

    protected function getTestBankAccount($type){
        //create a assets bank account
        $bankAccount = new BankAccount();
        $bankAccount->type = $type;
        $bankAccount->name = "Test".$type."Account_".uniqid();
        $bankAccount->displayName = "Test".$type."Account".uniqid();
        $bankAccount->bsb = 123456;
        $bankAccount->accountNumber = 123123123;
        return $bankAccount;
    }

    protected function removeTestComboItems(){
        $criteria = new FullComboItemCriteria();
        $criteria->codeBeginsWith = 'This is';
        $results = $this->api->searchEntities($criteria);

        foreach ($results as $result) {
            $this->api->deleteEntity($result);
        }
    }


    protected function getTestComboItem($code, $description){
        $e = new ComboItem();
        $e->code = $code;
        $e->description = $description;
        $e->isActive = 'true';
        $e->notes = "notes for $code";
        $e->isInventoried = 'true';
        //$e->assetAccountUid = $bankAccount->uid;
        $e->stockOnHand = 0; //will be ignore anyway
        $e->currentValue = 0;
        $e->isBought = 'true';
        $e->purchaseExpenseAccountUid = 0;
        $e->purchaseTaxCode =TaxCode::ExpInclGst;
        $e->minimumStockLevel = 99;
        $e->defaultReOrderQuantity = 20;
        $e->buyingPrice = 23;
        $e->isBuyingPriceIncTax = 'true';
        $e->isSold = 'true';
        //$e->saleIncomeAccountUid = 87349;
        $e->saleTaxCode = TaxCode::SaleInclGst;
        //$e->saleCoSAccountUid = 87348;
        $e->sellingPrice = 33;
        $e->isSellingPriceIncTax = 'true';
        $e->isVirtual = 'true';
        $e->vType = 'billing';
        $e->isVisible = 'true';
        $e->isVoucher = 'false';
        $e->validFrom = DateTime::getDate(time()-8640000);
        $e->validTo = DateTime::getDate(time()+86400000);

        return $e;
    }




    protected function removeTestInventoryItems(){
        $criteria = new FullInventoryItemCriteria();
        $criteria->descriptionBeginsWith = 'This is';

        $results = $this->api->searchEntities($criteria);

        //$this->assertGreaterThan(0, count($results));


        //test delete
        foreach ($results as $result) {
            $this->api->deleteEntity($result);
        }
    }


    protected function getTestInventoryItem($code, $description){

        $e = new InventoryItem();
        $e->code = $code;
        $e->description = $description;
        $e->isActive = 'true';
        $e->notes = "notes for $code";
        $e->isInventoried = 'true';
        //$e->assetAccountUid = $bankAccount->uid;
        $e->stockOnHand = 0; //will be ignore anyway
        $e->currentValue = 0;
        $e->isBought = 'true';
        $e->purchaseExpenseAccountUid = 0;
        $e->purchaseTaxCode =TaxCode::ExpInclGst;
        $e->minimumStockLevel = 99;
        $e->defaultReOrderQuantity = 20;
        $e->buyingPrice = 23;
        $e->isBuyingPriceIncTax = 'true';
        $e->isSold = 'true';
        //$e->saleIncomeAccountUid = 87349;
        $e->saleTaxCode = TaxCode::SaleInclGst;
        //$e->saleCoSAccountUid = 87348;
        $e->sellingPrice = 33;
        $e->isSellingPriceIncTax = 'true';
        $e->isVirtual = 'true';
        $e->vType = 'billing';
        $e->isVisible = 'true';
        $e->isVoucher = 'false';
        $e->validFrom = DateTime::getDate(time()-8640000);
        $e->validTo = DateTime::getDate(time()+86400000);

        return $e;

    }



}
