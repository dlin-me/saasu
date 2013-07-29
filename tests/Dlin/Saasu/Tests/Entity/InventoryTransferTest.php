<?php
/**
 * 
 * User: davidlin
 * Date: 16/07/13
 * Time: 11:49 PM
 * 
 */

namespace Dlin\Saasu\Tests\Entity;


use Dlin\Saasu\Criteria\InventoryTransferCriteria;
use Dlin\Saasu\Entity\InventoryAdjustment;
use Dlin\Saasu\Entity\InventoryAdjustmentItem;
use Dlin\Saasu\Entity\InventoryTransfer;
use Dlin\Saasu\Entity\InventoryTransferItem;
use Dlin\Saasu\Enum\AccountType;
use Dlin\Saasu\Util\DateTime;

class InventoryTransferTest extends TestBase{

    public function testIT(){
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

        $i2 = $this->getTestInventoryItem(uniqid().'2', 'This is a test');
        $i2->assetAccountUid = $assetAccount->uid;
        $i2->saleIncomeAccountUid = $incomeAccount->uid;
        $i2->saleCoSAccountUid =$cosAccount->uid;


        $this->api->saveEntities(array($i1, $i2));

        $this->assertGreaterThan(0, $i1->uid);
        $this->assertGreaterThan(0, $i2->uid);


        //get an account
        $account = $this->getTestBankAccount(AccountType::Asset);
        $this->api->saveEntity($account);


        //add some stock to both
        //create ia item
        $iaitem1 = new InventoryAdjustmentItem();
        $iaitem1->inventoryItemUid = $i1->uid;
        $iaitem1->quantity = 200;
        $iaitem1->accountUid = $account->uid;
        $iaitem1->unitPriceExclTax = 12;
        $iaitem1->totalPriceExclTax = 240;

        $iaitem2 = new InventoryAdjustmentItem();
        $iaitem2->inventoryItemUid = $i2->uid;
        $iaitem2->quantity = 200;
        $iaitem2->accountUid = $account->uid;
        $iaitem2->unitPriceExclTax = 12;
        $iaitem2->totalPriceExclTax = 240;



        $ia = new InventoryAdjustment();
        $ia->date = DateTime::getDate(time());
        $ia->notes = "This is a test";
        $ia->tags= "Test,me";
        $ia->requiresFollowUp = 'false';
        $ia->items = array($iaitem1, $iaitem2 );
        $this->api->saveEntity($ia);

        $this->assertGreaterThan(0, $ia->uid);

        //check that both inventory item has 200 instock;
        $this->api->loadEntity($i1);
        $this->api->loadEntity($i2);

        $this->assertEquals(200, $i1->stockOnHand);
        $this->assertEquals(200, $i2->stockOnHand);



        //create ia item tranfer
        $itItem1 = new InventoryTransferItem();
        $itItem1->inventoryItemUid = $i1->uid;
        $itItem1->quantity = 1;
        $itItem1->unitPriceExclTax = 12;
        $itItem1->totalPriceExclTax = 12;

        $itItem2 = new InventoryTransferItem();
        $itItem2->inventoryItemUid = $i2->uid;
        $itItem2->quantity = -1;
        $itItem2->unitPriceExclTax = 12;
        $itItem2->totalPriceExclTax = -12;


        //test create transer
        $it = new InventoryTransfer();
        $it->summary = "test transfering";
        $it->tags= "Test,me";
        $it->requiresFollowUp = 'false';

        $it->items = array($itItem1, $itItem2);

        $this->api->saveEntity($it);

        $this->assertGreaterThan(0, $ia->uid);

        //test if the stock changes
        $this->api->loadEntity($i1);
        $this->api->loadEntity($i2);

        $this->assertEquals(201, $i1->stockOnHand);
        $this->assertEquals(199, $i2->stockOnHand);



        //test update
        $it->summary="Just test again";
        $itItem1->quantity = -1;
        $itItem1->unitPriceExclTax = 12;
        $itItem1->totalPriceExclTax = -12;

        $itItem2->quantity = 1;
        $itItem2->unitPriceExclTax = 12;
        $itItem2->totalPriceExclTax = 12;
        $it->items = array($itItem1, $itItem2);
        $this->api->saveEntity($it);

        //test if the stock changes
        $this->api->loadEntity($i1);
        $this->api->loadEntity($i2);

        $this->assertEquals(199, $i1->stockOnHand);
        $this->assertEquals(201, $i2->stockOnHand);

        //test search

        $criteria = new InventoryTransferCriteria();
        $criteria->dateFrom = DateTime::getDate(time()-86400);

        $res = $this->api->searchEntities($criteria);

        $this->assertGreaterThan(0, count($res));

        //test delete
        $this->removeInventoryTransfer();

        //test if the quantity back to normal
        $this->api->loadEntity($i1);
        $this->api->loadEntity($i2);

        $this->assertEquals(200, $i1->stockOnHand);
        $this->assertEquals(200, $i2->stockOnHand);

        $this->removeInventoryAdjustment();


        //cleanup
        $this->removeTestInventoryItems();
        $this->removeTestBankAccounts();





    }

}