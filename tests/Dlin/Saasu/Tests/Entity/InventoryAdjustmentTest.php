<?php
/**
 * 
 * User: davidlin
 * Date: 16/07/13
 * Time: 11:49 PM
 * 
 */

namespace Dlin\Saasu\Tests\Entity;


use Dlin\Saasu\Criteria\BankAccountCriteria;
use Dlin\Saasu\Criteria\InventoryAdjustmentCriteria;
use Dlin\Saasu\Entity\InventoryAdjustment;
use Dlin\Saasu\Entity\InventoryAdjustmentItem;
use Dlin\Saasu\Enum\AccountType;
use Dlin\Saasu\Util\DateTime;

class InventoryAdjustmentTest extends TestBase{

    public function testIA(){
        //get an account
        $assetAccount = $this->getTestBankAccount(AccountType::Asset);
        $this->api->saveEntity($assetAccount);

        $incomeAccount = $this->getTestBankAccount(AccountType::Income);
        $this->api->saveEntity($incomeAccount);

        $cosAccount = $this->getTestBankAccount(AccountType::CostOfSales);
        $this->api->saveEntity($cosAccount);



        //create product
        $i1 = $this->getTestInventoryItem(uniqid().'1', 'This is a test');
        $i1->assetAccountUid = $assetAccount->uid;
        $i1->saleIncomeAccountUid = $incomeAccount->uid;
        $i1->saleCoSAccountUid =$cosAccount->uid;

        $this->api->saveEntities(array($i1));

        $this->assertGreaterThan(0, $i1->uid);


        //get an account
        $account = $this->getTestBankAccount(AccountType::Asset);
        $this->api->saveEntity($account);

        //create ia item
        $iaitem1 = new InventoryAdjustmentItem();
        $iaitem1->inventoryItemUid = $i1->uid;
        $iaitem1->quantity = 200;
        $iaitem1->accountUid = $account->uid;
        $iaitem1->unitPriceExclTax = 12;
        $iaitem1->totalPriceExclTax = 2400;


        //test create
        $ia = new InventoryAdjustment();
        $ia->date = DateTime::getDate(time());
        $ia->notes = "This is a test";
        $ia->tags= "Test,me";
        $ia->requiresFollowUp = 'false';

        $ia->items = array($iaitem1);

        $this->api->saveEntity($ia);

        $this->assertGreaterThan(0, $ia->uid);

        //test update
        $ia->notes="This is another test";

        $this->api->saveEntity($ia);

        //test load
        $iaCopy = new InventoryAdjustment();
        $iaCopy->uid = $ia->uid;
        $this->api->loadEntity($iaCopy);

        $this->assertEquals($ia->notes, $iaCopy->notes);

        //test search
        $criteria = new InventoryAdjustmentCriteria();
        $criteria->dateFrom = DateTime::getDate(time()-86400);

        $results = $this->api->searchEntities($criteria);

        //the ia must be one of the entity;
        $found =false;
        foreach($results as $res){
            if($res->uid == $ia->uid){
                $found = true;
            }
        }

        $this->assertTrue($found);

        //test remove
        foreach($results as $res){
            $this->api->deleteEntity($res);
        }

        $results = $this->api->searchEntities($criteria);
        $this->assertEquals(0, count($results));

        //cleanup
        $this->removeTestInventoryItems();
        $this->removeTestBankAccounts();





    }

}