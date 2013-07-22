<?php

namespace Dlin\Saasu\Tests\Entity;
use Dlin\Saasu\Criteria\DeletedEntityCriteria;
use Dlin\Saasu\Entity\Contact;
use Dlin\Saasu\Enum\EntityTypeUid;
use Dlin\Saasu\Enum\Salutation;
use Dlin\Saasu\Util\DateTime;


/**
 *
 * User: davidlin
 * Date: 21/05/13
 * Time: 12:04 AM
 *
 */


class DeletedEntityTest extends TestBase
{




    public function testDeletedEntity()
    {
        //create a contact
        $contact = new Contact();
        $contact->salutation = Salutation::Dr;
        $contact->givenName = 'Test';
        $contact->familyName = "Only";
        $contact->isActive = 'true';

        $this->api->saveEntity($contact);

        $uid = $contact->uid;

        $this->assertGreaterThan(0, $uid);

        //delete it
        $this->api->deleteEntity($contact);


        //search deleted item
        $deletedCriteria = new DeletedEntityCriteria();
        $deletedCriteria->entityTypeUid = EntityTypeUid::Contact;
        $deletedCriteria->utcDeletedFrom = new DateTime(time()-20);

        $result = $this->api->searchEntities($deletedCriteria);



        $hasFounded = false;
        foreach($result as $c){
            $hasFounded = $hasFounded || $c->entityUid == $uid;
        }

        $this->assertTrue($hasFounded);




    }
}
