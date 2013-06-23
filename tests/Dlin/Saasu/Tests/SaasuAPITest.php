<?php
namespace Dlin\Saasu\Tests;


use Dlin\Saasu\Criteria\InvoiceCriteria;
use Dlin\Saasu\Criteria\TransactionCategoryCriteria;
use Dlin\Saasu\Entity\Invoice;
use Dlin\Saasu\Entity\TransactionCategory;
use Dlin\Saasu\Enum\AccountType;
use Dlin\Saasu\Enum\TaxCode;
use Dlin\Saasu\SaasuAPI;
use Dlin\Saasu\Util\DateTime;

class SaasuAPITest extends \PHPUnit_Framework_TestCase
{
    public function testToXML()
    {
return;
        $entity = new TransactionCategory(1357532);


        $api = new SaasuAPI('CAD81524A8BB4F1B9AEE163FC0D42E7B', '39594');
      //  $api = new SaasuAPI('13DCA44F41364C6C92656705427D58E5', '25990');//real
        $api->loadEntity($entity);

        echo $entity->toXML();

    }


    public function testInsert()
    {




       $api = new SaasuAPI('CAD81524A8BB4F1B9AEE163FC0D42E7B', '39594');
        //$api = new SaasuAPI('13DCA44F41364C6C92656705427D58E5', '25990'); //real

        $c= new InvoiceCriteria();
        $c->transactionType = 's';

        $res = $api->searchEntities($c);


        print_r($res);

        return;




        $account = new TransactionCategory(1357532);
        $api->deleteEntity($account);




        //first create an account (transaction category)
        $account = new TransactionCategory();
        $account->uid = 0;
        $account->type = AccountType::Income;
        $account->name = "Consulting";
        $account->isActive = "true";
        $account->defaultTaxCode = TaxCode::SaleInclGst;
        $account->ledgerCode = "IT001";




        $api->saveEntity($account);

        $this->assertGreaterThan(0, $account->uid);

        $emptyAccount = new TransactionCategory();
        $emptyAccount->uid = $account->uid;

        $api->loadEntity($emptyAccount);

        $this->assertEquals($account->name, $emptyAccount->name);
        $this->assertEquals($account->type, $emptyAccount->type);
        $this->assertEquals($account->isActive, $emptyAccount->isActive);
        $this->assertEquals($account->defaultTaxCode, $emptyAccount->defaultTaxCode);
        $this->assertEquals($account->ledgerCode, $emptyAccount->ledgerCode);

        //list all accounts


/*

        $entity = new Invoice();
        $entity->uid = 0;
        $entity->transactionType = TransactionType::Sale;
        $entity->date = DateTime::getDate(mktime(0,0,0,9,30,2005));
        $entity->contactUid = 0;
        $entity->tags = "Online Sales, XYZ";
        $entity->summary = "Test POST sale";
        $entity->notes = "From REST";
        $entity->requiresFollowUp = false;
        $entity->dueOrExpiryDate = DateTime::getDate(mktime(0,0,0,12,1,2005));
        $entity->layout = InvoiceLayout::Service;
        $entity->status = InvoiceStatus::Invoice;
        $entity->invoiceNumber = "<Auto Number>";
        $entity->purchaseOrderNumber = 0

        //item 1
        $item1 = new ServiceInvoiceItem();
        $item1->description = "Design and Development of REST WS";
        $item1->accountUid = "";
        $item1->taxCode = TaxCode::SaleInclGst;
        $item1->totalAmountInclTax = 2132.51;

        $entity->invoiceItems[] = $item1;





    <invoiceItems>
      <serviceInvoiceItem>
        <accountUid>24502</accountUid>
        <totalAmountInclTax>2132.51</totalAmountInclTax>
      </serviceInvoiceItem>
      <serviceInvoiceItem>
        <description>Subscription to XYZ</description>
        <accountUid>24504</accountUid>
        <taxCode>G1</taxCode>
        <totalAmountInclTax>11.22</totalAmountInclTax>
      </serviceInvoiceItem>
    </invoiceItems>
    <quickPayment>
      <datePaid>2005-09-30</datePaid>
      <dateCleared />0001-01-01</dateCleared>
      <bankedToAccountUid>24509</bankedToAccountUid>
      <amount>100</amount>
      <reference>CASH</reference>
      <summary>Quick payment from Westpac.</summary>
    </quickPayment>
    <isSent>false</isSent>
        //$api = new SaasuAPI('CAD81524A8BB4F1B9AEE163FC0D42E7B', '39594');
        $api->saveEntity($entity);

        echo $entity->toXML();  */

    }

}