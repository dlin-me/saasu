<?php

namespace Dlin\Saasu\Tests\Entity;
use Dlin\Saasu\Criteria\FullComboItemCriteria;
use Dlin\Saasu\Entity\BuildComboItem;
use Dlin\Saasu\Entity\ComboItem;
use Dlin\Saasu\Entity\ComboItemItem;
use Dlin\Saasu\Entity\InventoryAdjustment;
use Dlin\Saasu\Entity\InventoryAdjustmentItem;
use Dlin\Saasu\Enum\AccountType;
use Dlin\Saasu\Util\DateTime;


/**
 *
 * User: davidlin
 * Date: 21/05/13
 * Time: 12:04 AM
 *
 */


class ComboItemTest extends TestBase
{

    public function testValidation(){


        $a = new ComboItem();
        $this->assertTrue($a->validate()->hasError());
        $this->assertTrue($a->validate()->hasError('code'));
        $a->code = uniqid();
        $this->assertFalse($a->validate()->hasError('code'));
        $this->assertTrue($a->validate()->hasError('description'));
        $a->description = "this is a description only";
        $this->assertFalse($a->validate()->hasError('description'));

    }


    public function testComboItem()
    {

        //clean up
        $this->removeTestComboItems();
        $this->removeTestInventoryItems();


        //create test bank accounts
        $assetAccount = $this->getTestBankAccount(AccountType::Asset);
        $this->api->saveEntity($assetAccount);

        $incomeAccount = $this->getTestBankAccount(AccountType::Income);
        $this->api->saveEntity($incomeAccount);

        $cosAccount = $this->getTestBankAccount(AccountType::CostOfSales);
        $this->api->saveEntity($cosAccount);


        //try creating comboitem without item
        $code = uniqid();
        //test add
        $item =  $this->getTestComboItem($code, "This is just a test only");
        $item->buyingPrice = 300;
        $item->sellingPrice = 400;

        $this->assertTrue($item->validate()->hasError('items'));

        $item->assetAccountUid = $assetAccount->uid;
        $item->saleIncomeAccountUid = $incomeAccount->uid;
        $item->saleCoSAccountUid =$cosAccount->uid;


        //create 2 inventory items
        $i1 = $this->getTestInventoryItem(uniqid(), 'This is just a test only');
        $i1->assetAccountUid = $assetAccount->uid;
        $i1->saleIncomeAccountUid = $incomeAccount->uid;
        $i1->saleCoSAccountUid =$cosAccount->uid;

        $i2 = $this->getTestInventoryItem(uniqid(), 'This is just a test only');
        $i2->assetAccountUid = $assetAccount->uid;
        $i2->saleIncomeAccountUid = $incomeAccount->uid;
        $i2->saleCoSAccountUid =$cosAccount->uid;

        $this->api->saveEntities(array($i1, $i2));
        $this->assertGreaterThan(0, $i1->uid);
        $this->assertGreaterThan(0, $i2->uid);


        //create some stocks for the inventory items, say 200 each
        $iaitem1 = new InventoryAdjustmentItem();
        $iaitem1->inventoryItemUid = $i1->uid;
        $iaitem1->quantity = 200;
        $iaitem1->accountUid = $i1->assetAccountUid;
        $iaitem1->unitPriceExclTax = 12;
        $iaitem1->totalPriceExclTax = 2400;

        $iaitem2 = new InventoryAdjustmentItem();
        $iaitem2->inventoryItemUid = $i2->uid;
        $iaitem2->quantity = 200;
        $iaitem2->accountUid = $i2->assetAccountUid;
        $iaitem2->unitPriceExclTax = 22;
        $iaitem2->totalPriceExclTax = 2400;

        $ia = new InventoryAdjustment();
        $ia->date = DateTime::getDate(time());
        $ia->notes = "This is a test";
        $ia->tags= "Test,me";
        $ia->requiresFollowUp = 'false';
        $ia->items = array($iaitem1, $iaitem2);

        $this->api->saveEntity($ia);


        //ok, lets try assigning items
        $ci1 = new ComboItemItem();
        $ci1->uid = $i1->uid;
        $ci1->code = $i1->code;
        $ci1->quantity =1;

        $ci2 = new ComboItemItem();
        $ci2->uid = $i2->uid;
        $ci2->code = $i2->code;
        $ci2->quantity =1;

        $item->items = array($ci1, $ci2);

        $this->assertFalse($item->validate()->hasError());

        //create combo item with uid
        $this->api->saveEntity($item);

        $this->assertGreaterThan(0, $item->uid);


        //test update
        $item->description = "This is another test only";
        $this->api->saveEntity($item);

        //test load/get
        $newItem = new ComboItem();
        $newItem->uid = $item->uid;
        $this->api->loadEntity($newItem);

        $this->assertEquals($item->code, $newItem->code);
        $this->assertEquals($item->description, $newItem->description);
        $this->assertEquals($item->sellingPrice, $newItem->sellingPrice);


        //test building
        $build= new BuildComboItem();
        $build->uid = $item->uid;
        $build->quantity = 5;
        $this->api->saveEntity($build);

        $this->assertGreaterThan(0, $build->uid);

        //need to delete the transfer, combo item , adjustment and items in order

        $this->removeInventoryTransfer();
        $this->api->deleteEntity($item); //comboitem
        $this->removeInventoryAdjustment();




        //check if they are really deleted;


        $criteria = new FullComboItemCriteria();
        $criteria->codeBeginsWith = 'This is';
        $results = $this->api->searchEntities($criteria);
        $this->assertEquals(0, count($results));

        $this->removeTestInventoryItems();
        $this->removeTestBankAccounts();



    }
}
