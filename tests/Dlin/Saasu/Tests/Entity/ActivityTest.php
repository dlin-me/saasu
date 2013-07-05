<?php

namespace Dlin\Saasu\Tests\Entity;
use Dlin\Saasu\Criteria\ActivityCriteria;
use Dlin\Saasu\Criteria\TagCriteria;
use Dlin\Saasu\Entity\Activity;
use Dlin\Saasu\Util\DateTime;


/**
 *
 * User: davidlin
 * Date: 21/05/13
 * Time: 12:04 AM
 *
 */


class ActivityTest extends TestBase
{


    public function testActivity()
    {
        //get a list of activies;
        $activities = $this->api->searchEntities(new ActivityCriteria());
        $this->assertEquals(0, count($activities));


        //just randomly get a tag
        $tags = $this->api->searchEntities(new TagCriteria());
        $tag = reset($tags);

        //test add
        $activity = new Activity();
        $activity->type = $tag->name;
        $activity->title = "This is a test asdfxxx activity";
        $activity->details = "details";
        $activity->due = DateTime::getDate('+10days');
        $this->api->saveEntity($activity);

        $this->assertGreaterThan(0, $activity->uid);

        //test load/get
        $newActivity = new Activity();
        $newActivity->uid = $activity->uid;
        $this->api->loadEntity($newActivity);

        $this->assertEquals($activity->title, $newActivity->title);
        $this->assertEquals($activity->details, $newActivity->details);
        $this->assertEquals($activity->owner, $newActivity->owner);

        //test search
        $criteria = new ActivityCriteria();
        $criteria->search = "asdfxxx";

        $results = $this->api->searchEntities($criteria);
        $found = reset($results);

        $this->assertNotNull($found);
        $this->assertEquals($found->title, $newActivity->title);
        $this->assertEquals($found->details, $newActivity->details);


        //test delete
        foreach ($results as $result) {
            $this->api->deleteEntity($result);
        }

        $activities = $this->api->searchEntities(new ActivityCriteria());
        $this->assertEquals(0, count($activities));

    }
}
