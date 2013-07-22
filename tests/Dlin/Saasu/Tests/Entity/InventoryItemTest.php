<?php

namespace Dlin\Saasu\Tests\Entity;
use Dlin\Saasu\Criteria\FullInventoryItemCriteria;
use Dlin\Saasu\Entity\InventoryItem;
use Dlin\Saasu\Enum\AccountType;
use Dlin\Saasu\Util\DateTime;


/**
 *
 * User: davidlin
 * Date: 21/05/13
 * Time: 12:04 AM
 *
 */


class InventoryItemTest extends TestBase
{

    public function testValidation(){

        $a = new InventoryItem();
        $this->assertTrue($a->validate()->hasError());
        $this->assertTrue($a->validate()->hasError('code'));
        $a->code = uniqid();
        $this->assertFalse($a->validate()->hasError('code'));
        $this->assertTrue($a->validate()->hasError('description'));
        $a->description = "this is a description only";
        $this->assertFalse($a->validate()->hasError('description'));


    }


    public function testInventoryItem()
    {
        $code = uniqid();
        //test add
        $item = $this->getTestInventoryItem($code, "This is just a test only");

        $assetAccount = $this->getTestBankAccount(AccountType::Asset);
        $this->api->saveEntity($assetAccount);

        $incomeAccount = $this->getTestBankAccount(AccountType::Income);
        $this->api->saveEntity($incomeAccount);

        $cosAccount = $this->getTestBankAccount(AccountType::CostOfSales);
        $this->api->saveEntity($cosAccount);

        $item->assetAccountUid = $assetAccount->uid;
        $item->saleIncomeAccountUid = $incomeAccount->uid;
        $item->saleCoSAccountUid =$cosAccount->uid;


        $this->assertFalse($item->validate()->hasError());

        $this->api->saveEntity($item);

        $this->assertGreaterThan(0, $item->uid);



        //test update
        $item->description = "This is another test only";
        $this->api->saveEntity($item);

        //test load/get
        $newItem = new InventoryItem();
        $newItem->uid = $item->uid;
        $this->api->loadEntity($newItem);

        $this->assertEquals($item->code, $newItem->code);
        $this->assertEquals($item->description, $newItem->description);
        $this->assertEquals($item->sellingPrice, $newItem->sellingPrice);


        //test search
        $criteria = new FullInventoryItemCriteria();
        $criteria->descriptionBeginsWith = 'This is';

        $results = $this->api->searchEntities($criteria);

        $this->assertGreaterThan(0, count($results));


        //test delete
        foreach ($results as $result) {
            $this->api->deleteEntity($result);
        }

        $results = $this->api->searchEntities($criteria);
        $this->assertEquals(0, count($results));

        $this->removeTestBankAccounts();

    }
}
