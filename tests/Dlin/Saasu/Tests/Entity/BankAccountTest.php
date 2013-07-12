<?php

namespace Dlin\Saasu\Tests\Entity;
use Dlin\Saasu\Criteria\BankAccountCriteria;
use Dlin\Saasu\Entity\BankAccount;
use Dlin\Saasu\Util\DateTime;


/**
 *
 * User: davidlin
 * Date: 21/05/13
 * Time: 12:04 AM
 *
 */


class BankAccountTest extends TestBase
{

    public function testValidation(){

        $a = new BankAccount();
        $this->assertTrue($a->validate()->hasError());
        $a->type= 'foo';
        $this->assertTrue($a->validate()->hasError('type'));
        $a->type= 'Equity';
        $this->assertFalse($a->validate()->hasError('type'));

        $this->assertTrue($a->validate()->hasError('displayName'));
        $a->displayName = "TestAccount";
        $this->assertFalse($a->validate()->hasError('displayName'));

        $this->assertFalse($a->validate()->hasError('bsb'));

        $this->assertFalse($a->validate()->hasError());



        $this->assertTrue($a->validate(true)->hasError('uid'));

        $a->uid = 123456;

        $this->assertFalse($a->validate(true)->hasError('uid'));

        $this->assertTrue($a->validate(true)->hasError('lastUpdatedUid'));



    }


    public function testBankAccount()
    {

        //test add
        $bankAccount = new BankAccount();
        $bankAccount->type = 'Asset';
        $bankAccount->name = "TestAccount_".uniqid();
        $bankAccount->displayName = "TestAccount";
        $bankAccount->bsb = 123456;
        $bankAccount->accountNumber = 123123123;

        $this->assertFalse($bankAccount->validate()->hasError());

        $this->api->saveEntity($bankAccount);

        $this->assertGreaterThan(0, $bankAccount->uid);




        //test update
        $bankAccount->displayName = "My Display BankAccount";
        $this->api->saveEntity($bankAccount);

        //test load/get
        $newBankAccount = new BankAccount();
        $newBankAccount->uid = $bankAccount->uid;
        $this->api->loadEntity($newBankAccount);

        $this->assertEquals($bankAccount->type, $newBankAccount->type);
        $this->assertEquals($bankAccount->name, $newBankAccount->name);
        $this->assertEquals($bankAccount->displayName, $newBankAccount->displayName);



        //test search
        $criteria = new BankAccountCriteria();
        $criteria->isInbuilt = 'false';
        $criteria->type = 'Asset';
        $criteria->isActive = 'true';



        $results = $this->api->searchEntities($criteria);

        $this->assertGreaterThan(0, count($results));


        //test delete
        foreach ($results as $result) {
            $this->api->deleteEntity($result);
        }

        $results = $this->api->searchEntities($criteria);
        $this->assertEquals(0, count($results));

    }
}
