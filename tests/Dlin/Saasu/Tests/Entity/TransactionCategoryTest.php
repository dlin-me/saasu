<?php

namespace Dlin\Saasu\Tests\Entity;
use Dlin\Saasu\Criteria\BankAccountCriteria;
use Dlin\Saasu\Criteria\TransactionCategoryCriteria;
use Dlin\Saasu\Entity\BankAccount;
use Dlin\Saasu\Entity\TransactionCategory;
use Dlin\Saasu\Util\DateTime;


/**
 *
 * User: davidlin
 * Date: 21/05/13
 * Time: 12:04 AM
 *
 */


class TransactionCategoryTest extends TestBase
{

    public function testValidation(){

        $a = new TransactionCategory();
        $this->assertTrue($a->validate()->hasError());
        $a->type= 'foo';
        $this->assertTrue($a->validate()->hasError('type'));
        $a->type= 'Equity';
        $this->assertFalse($a->validate()->hasError('type'));


    }


    public function testTransactionCategory()
    {


        //test add
        $account = new TransactionCategory();
        $account->type = 'Asset';
        $account->name = "TestAccount_".uniqid();
        $account->isActive = "true";

        $this->assertFalse($account->validate()->hasError());

        $this->api->saveEntity($account);

        $this->assertGreaterThan(0, $account->uid);




        //test update
        $account->name = "My Display BankAccount".uniqid();
        $this->api->saveEntity($account);

        //test load/get
        $newAccount = new TransactionCategory();
        $newAccount->uid = $account->uid;
        $this->api->loadEntity($newAccount);

        $this->assertEquals($account->type, $newAccount->type);
        $this->assertEquals($account->name, $newAccount->name);



        //test search
        $criteria = new TransactionCategoryCriteria();
        $criteria->isInbuilt = 'false';
        $criteria->type = 'Asset';
        $criteria->isActive = 'true';



        $results = $this->api->searchEntities($criteria);

        $this->assertGreaterThan(0, count($results));


        $hasFounded = false;
        foreach($results as $c){
            $hasFounded = $hasFounded || $c->uid == $account->uid;
        }

        $this->assertTrue($hasFounded);

        $this->api->deleteEntity($account);

        $results = $this->api->searchEntities($criteria);


        $hasFounded = false;
        foreach($results as $c){
            $hasFounded = $hasFounded || $c->uid == $account->uid;
        }

        $this->assertFalse($hasFounded);




    }
}
