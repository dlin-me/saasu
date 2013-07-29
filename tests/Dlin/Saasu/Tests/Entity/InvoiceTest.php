<?php
/**
 * 
 * User: davidlin
 * Date: 24/07/13
 * Time: 11:42 PM
 * 
 */
namespace Dlin\Saasu\Tests\Entity;



use Dlin\Saasu\Criteria\InvoiceCriteria;
use Dlin\Saasu\Entity\EmailMessage;
use Dlin\Saasu\Entity\EmailPdfInvoice;
use Dlin\Saasu\Entity\Invoice;
use Dlin\Saasu\Entity\InvoiceInstruction;
use Dlin\Saasu\Entity\QuickPayment;
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
use Dlin\Saasu\Util\DateTime;

class InvoiceTest extends TestBase{


    public function testValidation(){
        $i = new Invoice();

        $this->assertTrue($i->validate()->hasError('invoiceType'));

        $i->invoiceType = InvoiceTypeAU::SaleOrder;

        $this->assertFalse($i->validate()->hasError('invoiceType'));

        $this->assertTrue($i->validate()->hasError('date'));

        $i->date = false;

        $this->assertTrue($i->validate()->hasError('date'));

        $i->date = DateTime::getDate(time());

        $this->assertFalse($i->validate()->hasError('date'));

        $i->ccy = 'asdfasd';

        $this->assertTrue($i->validate()->hasError('ccy'));

        $i->ccy = 'aud';

        $this->assertFalse($i->validate()->hasError('ccy'));

        $this->assertTrue($i->validate()->hasError('layout'));
        $i->layout = 'TEST';
        $this->assertTrue($i->validate()->hasError('layout'));
        $i->layout = InvoiceLayout::Item;
        $this->assertFalse($i->validate()->hasError('layout'));


    }


    public function testInvoice(){



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

        //parepare a quick payment
        $payment = new QuickPayment();
        $payment->datePaid = DateTime::getDate(time());
        $payment->dateCleared = DateTime::getDate(time());
        $payment->bankedToAccountUid = $bankAccount->uid;
        $payment->amount = 100;
        $payment->reference = 'Cash';
        $payment->summary = "Quick Test payment";

        //prepare a email;
        $email = new EmailMessage();
        $email->to = "davidlinmail@hotmail.com";
        $email->from = "david.lin.au@gmail.com";
        $email->subject = "test saasue";
        $email->body = "test body";

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


        //test emailPdfInvoice

        $emailPdfInvoice = new EmailPdfInvoice();
        $emailPdfInvoice->emailMessage = $email;
        $emailPdfInvoice->invoiceUid = $i->uid;

        $this->api->saveEntity($emailPdfInvoice);



        //test update with instruction to send email
        $i->summary = "Test update me";
        $i->quickPayment = $payment;

        $instruction = new InvoiceInstruction();

        $instruction->emailMessage = $email;
        $instruction->emailToContact = 'true';

        $this->api->saveEntity($i, $instruction);


        //test load
        $i2  = new Invoice();
        $i2->uid = $i->uid;
        $this->api->loadEntity($i2, array('incpayments'=>'true'));

        $this->assertEquals($i->summary, $i2->summary);


        //test search
        $criteria = new InvoiceCriteria();
        $criteria->transactionType = TransactionType::Sale;
        $criteria->paidStatus = PaidStatus::All;
        $res = $this->api->searchEntities($criteria);
        $this->assertGreaterThan(0, count($res));

        //test delete
        foreach($res as $n){
            $this->api->deleteEntity($n);
        }

        $criteria = new InvoiceCriteria();

        $criteria->transactionType = TransactionType::Sale;
        $criteria->paidStatus = PaidStatus::All;
        $res = $this->api->searchEntities($criteria);
        $this->assertEquals(0, count($res));



        $this->api->deleteEntity($account);
        $this->api->deleteEntity($bankAccount);






    }

}