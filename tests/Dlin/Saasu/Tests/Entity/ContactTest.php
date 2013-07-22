<?php

namespace Dlin\Saasu\Tests\Entity;
use Dlin\Saasu\Criteria\ContactCriteria;
use Dlin\Saasu\Entity\Contact;
use Dlin\Saasu\Entity\PostalAddress;
use Dlin\Saasu\Entity\TradingTerms;
use Dlin\Saasu\Enum\IntervalType;
use Dlin\Saasu\Enum\Salutation;
use Dlin\Saasu\Enum\TradingTermsType;
use Dlin\Saasu\Util\DateTime;


/**
 *
 * User: davidlin
 * Date: 21/05/13
 * Time: 12:04 AM
 *
 */


class ContactTest extends TestBase
{




    public function testContact()
    {

        //test add
        $contact = new Contact();
        $contact->salutation = Salutation::Dr;
        $contact->givenName = 'Test';
        $contact->familyName = "Only";

        $contact->organisationName = 'Saasyssss.tv';
        $contact->organisationAbn = "777888993";
        $contact->organisationPosition = "Director";
        $contact->email = "john.smith@saasy.tv";
        $contact->mainPhone = "02 9999 9999";
        $contact->mobilePhone = "0444 444 444";
        $contact->contactID = "XYZ123";
        $contact->tags = "Gold Prospect, Film";

        $postalAddress= new PostalAddress();
        $postalAddress->street = "3/33 Victory Av";
        $postalAddress->city = "North Sydney";
        $postalAddress->state = "NSW";
        $postalAddress->postCode = 2000;
        $postalAddress->country = 'Australia';
        $contact->postalAddress = $postalAddress;
        $contact->isActive = 'true';

        $saleTradingTerms = new TradingTerms();
        $saleTradingTerms->type =  TradingTermsType::DueIn;
        $saleTradingTerms->interval = 7;
        $saleTradingTerms->intervalType = IntervalType::Day;

        $contact->saleTradingTerms = $saleTradingTerms;

        $purchaseTradingTerms = new TradingTerms();
        $purchaseTradingTerms->type = TradingTermsType::DueInEomPlusXDays;
        $purchaseTradingTerms->interval = 14;
        $purchaseTradingTerms->intervalType = IntervalType::Day;

        $contact->purchaseTradingTerms = $purchaseTradingTerms;

        $this->api->saveEntity($contact);

        $this->assertGreaterThan(0, $contact->uid);

        //test update
        $contact->familyName = "Test";

        $this->api->saveEntity($contact);


        //test load/get
        $newContact = new Contact();
        $newContact->uid = $contact->uid;
        $this->api->loadEntity($newContact);

        $this->assertEquals($contact->familyName, $newContact->familyName);
        $this->assertEquals($contact->givenName, $newContact->givenName);



        //test search

        $criteria = new ContactCriteria();
        $criteria->familyName = "Test";

        $results = $this->api->searchEntities($criteria);


        $this->assertGreaterThan(0, count($results));

        $found = reset($results);


        $this->assertEquals($found->givenName, $newContact->givenName);


        $this->api->deleteEntity($found);

        foreach($results as $result){
            $this->api->deleteEntity($result);
        }


        $contacts = $this->api->searchEntities($criteria);
        $this->assertEquals(0, count($contacts));

    }
}
