<?php
namespace Dlin\Saasu\Entity;

use Dlin\Saasu\Entity\PostalAddress;
use Dlin\Saasu\Enum\Salutation;
use Dlin\Saasu\Validator\Validator;

class Contact extends EntityBase
{


    public function __construct($uid = null)
    {
        parent::__construct($uid);
        $this->postalAddress = new PostalAddress();
        $this->otherAddress = new PostalAddress();
    }


    public $salutation;
    public $givenName;
    public $middleInitials;
    public $familyName;
    public $organisationUid;
    public $organisationName;

    public $organisationAbn;
    public $companyEmail;

    public $organisationWebsite;
    public $organisationPosition;

    public $contactID;
    public $websiteUrl;
    public $email;
    public $mainPhone;

    public $homePhone;
    public $fax;
    public $mobilePhone;
    public $otherPhone;
    public $postalAddress;

    public $otherAddress;
    public $isActive;
    public $acceptDirectDeposit;
    public $directDepositBankName;
    public $directDepositAccountName;
    public $directDepositBsb;
    public $directDepositAccountNumber;
    public $acceptCheque;
    public $chequePayableTo;
    /**
     * Comma separated strings, each less than 35 characters
     * @var
     */
    public $tags;
    public $customField1;
    public $customField2;
    public $twitterID;
    public $skypeID;
    public $linkedInPublicProfile;
    public $autoSendStatement;
    public $isPartner;
    public $isCustomer;
    public $isSupplier;
    public $contactManagerUid;
    public $saleTradingTermsPaymentDueInInterval;
    public $saleTradingTermsPaymentDueInIntervalType;
    public $purchaseTradingTermsPaymentDueInInterval;
    public $purchaseTradingTermsPaymentDueInIntervalType;
    public $saleTradingTerms;
    public $purchaseTradingTerms;
    public $defaultSaleDiscount;
    public $defaultPurchaseDiscount;


    public function validate($forUpdate = false)
    {

        return Validator::instance()->
            lookAt($this->uid, 'uid')->required($forUpdate)->int()->
            lookAt($this->lastUpdatedUid, 'lastUpdatedUid')->required($forUpdate)->int()->
            lookAt($this->salutation, 'salutation')->inArray(Salutation::values())->
            lookAt($this->givenName, 'givenName')->length(0,50)->
            lookAt($this->middleInitials, 'middleInitials')->length(0,3)->
            lookAt($this->familyName, 'familyName')->length(0,50)->
            lookAt($this->organisationName, 'organisationName')->length(0,75)->
            lookAt($this->organisationAbn, 'organisationAbn')->length(0,11)->
            lookAt($this->organisationWebsite, 'organisationWebsite')->length(0,1024)->
            lookAt($this->organisationPosition, 'organisationPosition')->length(0,75)->
            lookAt($this->contactID, 'contactID')->length(0,50)->
            lookAt($this->websiteUrl, 'websiteUrl')->length(0,1024)->
            lookAt($this->email, 'email')->length(0,128)->
            lookAt($this->mainPhone, 'mainPhone')->length(0,20)->
            lookAt($this->homePhone, 'homePhone')->length(0,20)->
            lookAt($this->fax, 'fax')->length(0,20)->
            lookAt($this->mobilePhone, 'mobilePhone')->length(0,20)->
            lookAt($this->otherPhone, 'otherPhone')->length(0,20)->
            lookAt($this->isActive, 'isActive')->bool()->
            lookAt($this->acceptDirectDeposit, 'acceptDirectDeposit')->bool()->
            lookAt($this->directDepositAccountName, 'directDepositAccountName')->length(0,75)->
            lookAt($this->directDepositBsb, 'directDepositBsb')->length(0,3)->
            lookAt($this->directDepositAccountNumber, 'directDepositAccountNumber')->length(0,20)->
            lookAt($this->acceptCheque, 'acceptCheque')->bool()->
            lookAt($this->chequePayableTo, 'chequePayableTo')->length(0,75)->
            lookAt($this->customField1, 'customField1')->length(0,50)->
            lookAt($this->customField2, 'customField2')->length(0,50)->
            lookAt($this->twitterID, 'twitterID')->length(0,100)->
            lookAt($this->skypeID, 'skypeID')->length(0,100)->
            lookAt($this->defaultSaleDiscount, 'defaultSaleDiscount')->numeric()->
            lookAt($this->defaultPurchaseDiscount, 'defaultPurchaseDiscount')->numeric();

    }
}
