<?php
/**
 * 
 * User: davidlin
 * Date: 27/07/13
 * Time: 10:53 PM
 * 
 */

namespace Dlin\Saasu\Tests\Entity;


use Dlin\Saasu\Criteria\InvoicePaymentCriteria;
use Dlin\Saasu\Entity\InvoicePayment;
use Dlin\Saasu\Entity\InvoicePaymentItem;
use Dlin\Saasu\Enum\AccountType;
use Dlin\Saasu\Enum\TransactionType;
use Dlin\Saasu\Util\DateTime;

class InvoicePaymentTest extends TestBase {

    public function testValidation(){
        $ip = new InvoicePayment();
        $this->assertTrue($ip->validate(false)->hasError());
        $ip->date = DateTime::getDate(time());
        $this->assertFalse($ip->validate(false)->hasError('date'));
        $this->assertTrue($ip->validate(false)->hasError('transactionType'));
        $ip->transactionType = TransactionType::AccountOpeningBalance;
        $this->assertFalse($ip->validate(false)->hasError('date'));

    }

    public function testInvoicePayment(){
/*
        $this->removeTestInvoicePayments();

        $this->removeTestInvoices();

        $this->removeTestTransactionCategories();

        $this->removeTestBankAccounts();
*/

        //create a bankaccount
        $bankAccount = $this->getTestBankAccount(AccountType::Income);
        $this->api->saveEntity($bankAccount);

        //create a payment
        $p = new InvoicePayment();
        $p->transactionType = TransactionType::SalePayment;
        $p->date = DateTime::getDate(time());
        $p->dateCleared = DateTime::getDate(time());
        $p->reference = uniqid();
        $p->summary = "Test payment";
        $p->requiresFollowUp = "false";
        $p->paymentAccountUid =$bankAccount->uid;





        //create an item
        //first create an invoice to pay for
        $invoice = $this->getTestInvoice(); //100 dollar
        $i = new InvoicePaymentItem();
        $i->amount = 50;
        $i->invoiceUid = $invoice->uid;

        $p->invoicePaymentItems = array($i);



        $this->api->saveEntity($p);

        $this->assertGreaterThan(0, $p->uid);


        //test update
        $p->summary = "Test Updated";
        $i->amount = 60;
        $p->invoicePaymentItems = array($i);

        $this->api->saveEntity($p);


        //test search/list
        $criteria = new InvoicePaymentCriteria();
        $criteria->transactionType = TransactionType::SalePayment;
        $criteria->bankAccountUid = $bankAccount->uid;

        $res = $this->api->searchEntities($criteria);

        $this->assertEquals(1, count($res));

        $res = reset($res);//get the first one;

       $this->assertEquals($p->summary, $res->summary);

       $this->assertEquals(60, $res->getExtra('amount'));


        //test delete
        $this->api->deleteEntity($p);

        $this->removeTestInvoices();

        $this->removeTestTransactionCategories();

        $this->removeTestBankAccounts();




    }

}