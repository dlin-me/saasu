<?php

namespace Dlin\Saasu\Tests\Entity;
use Dlin\Saasu\Criteria\BankAccountCriteria;
use Dlin\Saasu\Criteria\FullComboItemCriteria;
use Dlin\Saasu\Criteria\FullInventoryItemCriteria;
use Dlin\Saasu\Criteria\InventoryAdjustmentCriteria;
use Dlin\Saasu\Criteria\InventoryTransferCriteria;
use Dlin\Saasu\Criteria\InvoiceCriteria;
use Dlin\Saasu\Criteria\InvoicePaymentCriteria;
use Dlin\Saasu\Criteria\TransactionCategoryCriteria;
use Dlin\Saasu\Entity\BankAccount;
use Dlin\Saasu\Entity\ComboItem;
use Dlin\Saasu\Entity\InventoryItem;
use Dlin\Saasu\Entity\Invoice;
use Dlin\Saasu\Entity\ServiceInvoiceItem;
use Dlin\Saasu\Entity\TradingTerms;
use Dlin\Saasu\Entity\TransactionCategory;
use Dlin\Saasu\Enum\AccountType;
use Dlin\Saasu\Enum\IntervalType;
use Dlin\Saasu\Enum\InvoiceLayout;
use Dlin\Saasu\Enum\InvoiceStatus;
use Dlin\Saasu\Enum\InvoiceTypeAU;
use Dlin\Saasu\Enum\PaidStatus;
use Dlin\Saasu\Enum\TaxCode;
use Dlin\Saasu\Enum\TradingTermsType;
use Dlin\Saasu\Enum\TransactionType;
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
        $this->api = new SaasuAPI('D4A92597762C4FDCAF66FF03C988B7B0', '41509');
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


    protected function removeInventoryAdjustment(){
        $list = $this->api->searchEntities(new InventoryAdjustmentCriteria());
        foreach($list as $item){
            $this->api->deleteEntity($item);
        }
    }


    protected function removeInventoryTransfer(){
        $list = $this->api->searchEntities(new InventoryTransferCriteria());
        foreach($list as $item){
            $this->api->deleteEntity($item);
        }
    }


    protected function removeTestInvoices(){
        $criteria = new InvoiceCriteria();
        $criteria->transactionType = TransactionType::Sale;
        $criteria->paidStatus = PaidStatus::All;
        $res = $this->api->searchEntities($criteria);


        //test delete
        foreach($res as $n){
            $this->api->deleteEntity($n);
        }

    }


    protected function getTestInvoice(){
        //prepare a bank account
        $bankAccount = $this->getTestBankAccount(AccountType::Income);
        $this->api->saveEntity($bankAccount);
        $this->assertGreaterThan(0, $bankAccount->uid);

        $account = new TransactionCategory();
        $account->type = AccountType::CostOfSales;
        $account->name = "TestAccount_".uniqid();
        $account->isActive = "true";
        $this->api->saveEntity($account);


        //prepare two items
        $item1 = new ServiceInvoiceItem();
        $item1->description = "test service 1";
        $item1->accountUid = $account->uid;
        $item1->taxCode = TaxCode::SaleInclGst;
        $item1->totalAmountInclTax = 11.12;

        $item2 = new ServiceInvoiceItem();
        $item2->description = "test service 2";
        $item2->accountUid = $account->uid;
        $item2->taxCode = TaxCode::SaleInclGst;
        $item2->totalAmountInclTax = 88.88;


        //test create
        $i= new Invoice();
        $i->invoiceType = InvoiceTypeAU::TaxInvoice;
        $i->transactionType = TransactionType::Sale;
        $i->date = DateTime::getDate(time());
        $i->summary = "This is a test summary";
        $i->notes = "Test";
        $i->tags="test";
        $i->requiresFollowUp = 'false';
        $i->dueOrExpiryDate = DateTime::getDate(time()+86400*14);
        $i->layout = InvoiceLayout::Service;
        $i->status = InvoiceStatus::Invoice;
        //$i->invoiceNumber = "<Auto Number>";
        $tradingTerms = new TradingTerms();
        $tradingTerms->type = TradingTermsType::DueIn;
        $tradingTerms->intervalType = IntervalType::Day;
        $tradingTerms->interval = 14;
        $i->tradingTerms = $tradingTerms;

        $i->isSent = 'false';
        $i->invoiceItems = array($item1, $item2);

        $this->api->saveEntity($i);

        return $i;
    }

    protected function removeTestTransactionCategories(){
        //test search
        $criteria = new TransactionCategoryCriteria();
        $criteria->isInbuilt = 'false';
        $res = $this->api->searchEntities($criteria);


        //test delete
        foreach($res as $n){
            $this->api->deleteEntity($n);
        }
    }


    protected function removeTestInvoicePayments(){
        $criteria = new InvoicePaymentCriteria();
        $criteria->transactionType = TransactionType::SalePayment;
        $res = $this->api->searchEntities($criteria);


        //test delete
        foreach($res as $n){
            $this->api->deleteEntity($n);
        }
    }

    protected function getTestTransactionCategory(){
        $account = new TransactionCategory();
        $account->type = AccountType::CostOfSales;
        $account->name = "TestAccount_".uniqid();
        $account->isActive = "true";

        return $account;
    }

}
