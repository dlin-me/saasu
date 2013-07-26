<?php
namespace Dlin\Saasu\Entity;

use Dlin\Saasu\Validator\Validator;

class Invoice extends EntityBase
{
    public function  __construct($uid=null)
    {
        parent::__construct($uid);
        $this->tradingTerms = new TradingTerms();
        $this->quickPayment = new QuickPayment();
        $this->invoiceItems = array();
    }


    public $transactionType;
    public $invoiceType;
    public $contactUid;
    public $shipToContactUid;
    public $externalNotes;
    public $dueOrExpiryDate;
    public $layout;
    public $status;
    public $invoiceNumber;
    public $purchaseOrderNumber;
    public $invoiceItems;
    public $quickPayment;

    public $tradingTerms;
    public $isSent;

    public $totalAmountInclTax;

    public $totalAmountExclTax;

    public $totalTaxAmount;

    public $autoPopulateFxRate;

    public $date;
    public $tags;
    public $summary;
    public $notes;
    public $requiresFollowUp;
    public $ccy;
    public $fcToBcFxRate;




    public function validate($forUpdate = false)
    {


        return Validator::instance()->
            lookAt($this->uid, 'uid')->required($forUpdate)->int()->
            lookAt($this->lastUpdatedUid, 'lastUpdatedUid')->required($forUpdate)->int()->
            lookAt($this->transactionType, 'transactionType')->required(true)->enum('S','P')->
            lookAt($this->invoiceType, 'invoiceType')->required(true)->
            lookAt($this->date, 'date')->required(true)->date()->
            lookAt($this->contactUid, 'contactUid')->int()->
            lookAt($this->shipToContactUid, 'shipToContactUid')->int()->
            lookAt($this->summary, 'summary')->length(0,75)->
            lookAt($this->ccy, 'ccy')->length(0,3)->
            lookAt($this->autoPopulateFxRate, 'autoPopulateFxRate')->bool()->
            lookAt($this->fcToBcFxRate, 'fcToBcFxRate')->numeric()->
            lookAt($this->requiresFollowUp, 'requiresFollowUp')->bool()->
            lookAt($this->dueOrExpiryDate, 'dueOrExpiryDate')->date()->
            lookAt($this->layout, 'layout')->required(true)->enum('S','I')->
            lookAt($this->status, 'status')->required(true)->enum('','Q','O','I')->
            lookAt($this->invoiceNumber, 'invoiceNumber')->length(0,50)->
            lookAt($this->purchaseOrderNumber, 'purchaseOrderNumber')->length(0,50)->
            lookAt($this->isSent, 'isSent')->bool();

    }


}
