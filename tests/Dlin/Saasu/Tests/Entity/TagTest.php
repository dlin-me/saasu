<?php
/**
 *
 * User: davidlin
 * Date: 3/07/13
 * Time: 11:33 PM
 *
 */

namespace Dlin\Saasu\Tests\Entity;


use Dlin\Saasu\Criteria\TagCriteria;
use Dlin\Saasu\Entity\Tag;

class TagTest extends TestBase
{


    public function testTag()
    {

        //get a list of activies;
        $c = new TagCriteria();
        $tags = $this->api->searchEntities($c);
        $numExistingTags = count($tags);


        //test add (tag can not be added)
        $new = new Tag();
        $new->name = "test";
        $this->api->saveEntity($new);

        $this->assertEquals(0, $new->uid);


        //test update (not updatable)
        /**
         * @var \Dlin\Saasu\Entity\Tag $tag
         *
         */
        $tag = reset($tags);
        $tag->name = "TEST";
        $lastModified = $tag->utcLastModified;
        $this->api->saveEntity($tag);
        $this->assertEquals($lastModified, $tag->utcLastModified);


        //test delete ( not deletable )
        $this->api->deleteEntity($new);
        $tags = $this->api->searchEntities($c);
        $this->assertEquals($numExistingTags, count($tags));


    }
}