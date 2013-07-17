<?php

namespace Dlin\Saasu\Tests\Entity;
use Dlin\Saasu\Criteria\BankAccountCriteria;
use Dlin\Saasu\Criteria\FullComboItemCriteria;
use Dlin\Saasu\Criteria\FullInventoryItemCriteria;
use Dlin\Saasu\Entity\BuildComboItem;
use Dlin\Saasu\Entity\ComboItem;
use Dlin\Saasu\Entity\ComboItemItem;
use Dlin\Saasu\Entity\InventoryItem;


use Dlin\Saasu\Enum\AccountType;
use Dlin\Saasu\Enum\TaxCode;
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


        $criteria = new FullComboItemCriteria();
        $criteria->codeBeginsWith = 'This is';
        $results = $this->api->searchEntities($criteria);
        //test delete
        foreach ($results as $result) {
            $this->api->deleteEntity($result);
        }


        //delete test data first
        $criteria = new FullInventoryItemCriteria();
        $criteria->descriptionBeginsWith = 'This is';
        $results = $this->api->searchEntities($criteria);
        //test delete
        foreach ($results as $result) {
            $this->api->deleteEntity($result);
        }





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



        $this->api->deleteEntity($item);
        $this->api->deleteEntity($i1);
        $this->api->deleteEntity($i2);


        //check if they are really deleted;
        $criteria = new FullInventoryItemCriteria();
        $criteria->descriptionBeginsWith = 'This is';
        $results = $this->api->searchEntities($criteria);
        $this->assertEquals(0, count($results));



        $criteria = new FullComboItemCriteria();
        $criteria->codeBeginsWith = 'This is';
        $results = $this->api->searchEntities($criteria);
        $this->assertEquals(0, count($results));


        $this->removeTestBankAccounts();



    }
}
