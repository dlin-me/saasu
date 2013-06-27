<?php
namespace Dlin\Saasu\Entity;

class InvoicePayment extends EntityBase
{

    public function __construct($uid=null){
        parent::__construct($uid);
        $this->items = array();
    }

    public $transactionType;
    public $date;
    public $ccy;
    public $autoPopulateFXRate;
    public $fCToBCFXRate;

    public $fee;
    public $reference;
    public $summary;
    public $notes;
    public $requiresFollowUp;
    public $paymentAccountUid;
    public $dateCleared;
    public $items;
}
