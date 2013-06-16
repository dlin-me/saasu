<?php
namespace Dlin\Saasu\Entity;

class Invoice extends Transaction
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
}
