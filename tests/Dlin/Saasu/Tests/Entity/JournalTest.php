<?php
/**
 * 
 * User: davidlin
 * Date: 28/07/13
 * Time: 12:37 AM
 * 
 */

namespace Dlin\Saasu\Tests\Entity;


use Dlin\Saasu\Criteria\JournalCriteria;
use Dlin\Saasu\Entity\Journal;
use Dlin\Saasu\Entity\JournalItem;
use Dlin\Saasu\Enum\JournalItemType;
use Dlin\Saasu\Util\DateTime;

class JournalTest extends TestBase {

    public function testJournal(){
        $j = new Journal();
        $j->date = DateTime::getDate(time());
        $j->summary = 'Test';
        $j->notes = 'Test note';
        $j->requiresFollowUp = 'false';
        $j->reference = 'Test reference';

        //create two transaction category
        $acc1 = $this->getTestTransactionCategory();
        $acc2 = $this->getTestTransactionCategory();
        $this->api->saveEntities(array($acc1,$acc2));

        //create two items
        $i1 = new JournalItem();
        $i1->accountUid = $acc1->uid;
        $i1->amount = 123;
        $i1->type = JournalItemType::Credit;

        $i2 = new JournalItem();
        $i2->accountUid = $acc1->uid;
        $i2->amount = 123;
        $i2->type = JournalItemType::Debit;

        $j->journalItems = array($i1, $i2);

        //test create
        $this->api->saveEntity($j);

        $this->assertGreaterThan(0, $j->uid);

        //test update
        $j->summary ="Updated Summary";
        $i1->amount = $i2->amount = 100;
        $j->journalItems = array($i1, $i2);

        $this->api->saveEntity($j);


        //test search
        $results = $this->api->searchEntities( new JournalCriteria());

        $found = false;
        foreach($results as $result){
            if($result->uid == $j->uid){
                $found = $result;
                break;
            }
        }

        $this->assertTrue($found?true:false);

        $this->assertEquals($j->summary , $found->summary);

        $this->api->deleteEntity($j);

        $this->removeTestTransactionCategories();

    }
}