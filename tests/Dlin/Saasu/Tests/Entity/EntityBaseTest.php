<?php

namespace Dlin\Saasu\Tests\Entity;

use Dlin\Saasu\Entity\Checkout;
use Dlin\Saasu\Entity\Contact;
use Dlin\Saasu\Entity\PostalAddress;

/**
 *
 * User: davidlin
 * Date: 21/05/13
 * Time: 12:04 AM
 *
 */


class EntityBaseTest extends \PHPUnit_Framework_TestCase
{
    public function testToXML()
    {

        $billingAddress = new PostalAddress();
        $billingAddress->city = 'melbourne';
        $billingAddress->street = 'market street';
        $billingAddress->country = 'australia';
        $billingAddress->postCode = '3000';
        $billingAddress->state = 'Victoria';

        $invoiceAddress = new PostalAddress();
        $invoiceAddress->city = 'sydney';
        $invoiceAddress->street = 'invoice street';
        $invoiceAddress->country = 'australia';
        $invoiceAddress->postCode = '2000';
        $invoiceAddress->state = 'new south whales';


        $billingContact = new Contact();
        $billingContact->salutation = "Mr";
        $billingContact->givenName = "firstname";
        $billingContact->postalAddress = $invoiceAddress;
        $billingContact->otherAddress = $billingAddress;
        $billingContact->familyName = 'lastname';
        $billingContact->mobilePhone = '123456789';
        $billingContact->companyEmail = 'asdf@eewfas.com';


        $entity = new Checkout();
        $entity->uid = 123456;
        $entity->paymentAmount = 123123;
        $entity->emailReceipt = 'hello@sfdasd.com';
        $entity->emailReceiptUsingTemplateUid = 123;
        $entity->billingContact = $billingContact;


        $xml = $entity->toXML();

        $entity2 = new Checkout();

        $entity2->fromXML($xml);


        $var = $entity2->toXML();


        $this->assertEquals($xml, $var);


        $this->assertEquals('checkout', $entity2->getName());
    }
}
