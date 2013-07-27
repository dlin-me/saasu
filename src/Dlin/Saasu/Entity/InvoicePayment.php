<?php
namespace Dlin\Saasu\Entity;

use Dlin\Saasu\Validator\Validator;

class InvoicePayment extends EntityBase
{
    /**
     * Constructor
     * @param null $uid
     */
    public function __construct($uid=null){
        parent::__construct($uid);
        $this->invoicePaymentItems = array();
    }

    public $transactionType;
    public $date;
    public $ccy;
    public $autoPopulateFxRate;
    public $fcToBcFxRate;

    public $fee;
    public $reference;
    public $summary;
    public $notes;
    public $requiresFollowUp;
    public $paymentAccountUid;
    public $dateCleared;
    public $invoicePaymentItems;

    /**
     * @param boolean $forUpdate
     * @return Validator
     */
    public function validate($forUpdate){

        return Validator::instance()->
            lookAt($this->uid, 'uid')->required($forUpdate)->int()->
            lookAt($this->lastUpdatedUid, 'lastUpdatedUid')->required($forUpdate)->int()->
            lookAt($this->transactionType, 'transactionType')->enum('SP','PP')->required(true)->
            lookAt($this->date, 'date')->required(true)->date()->
            lookAt($this->reference, 'reference')->length(0,50)->
            lookAt($this->summary, 'summary')->length(0,75)->
            lookAt($this->ccy, 'ccy')->length(0,3)->
            lookAt($this->autoPopulateFxRate, 'autoPopulateFxRate')->bool()->
            lookAt($this->fcToBcFxRate, 'fcToBcFxRate')->numeric()->
            lookAt($this->requiresFollowUp, 'requiresFollowUp')->bool()->
            lookAt($this->paymentAccountUid, 'paymentAccountUid')->int()->
            lookAt($this->dateCleared, 'dateCleared')->date()->
            lookAt($this->fee, 'fee')->numeric();
    }
}
