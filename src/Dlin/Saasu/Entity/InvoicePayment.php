<?php
namespace Dlin\Saasu\Entity;

class InvoicePayment extends EntityBase
{


    public function __construct($transactionType)
    {
        $this->TransactionType = $transactionType;
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
    public $requiresFollowUp = false;
    public $paymentAccountUid;
    public $dateCleared;
    public $items = array();
}
