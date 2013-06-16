<?php
namespace Dlin\Saasu\Entity;

use Dlin\Saasu\Entity\PostalAddress;

class Contact extends EntityBase
{

    public function __construct(){

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
    public $isActive = true;
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
    public $twitterId;
    public $skypeId;
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
}
