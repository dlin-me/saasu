<?php

namespace Dlin\Saasu\Tests\Entity;
use Dlin\Saasu\Criteria\FullComboItemCriteria;
use Dlin\Saasu\Entity\ComboItem;
use Dlin\Saasu\Entity\ComboItemItem;
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

        $i  = new ComboItemItem();
        $i->code = 1234;
        $i->quantity = 0;


    }


    public function testComboItem()
    {

        return;
        $code = uniqid();
        //test add
        $item = new ComboItem();
        $item->code = $code;
        $item->description = "This is just a test only";
        $item->isActive = 'true';
        $item->buyingPrice = 100;
        $item->sellingPrice = 200;


        $this->assertFalse($item->validate()->hasError());

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


        //test search
        $criteria = new FullComboItemCriteria();
        $criteria->descriptionBeginsWith = 'This is';

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
