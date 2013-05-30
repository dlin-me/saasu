<?php
namespace Dlin\Saasu\Entity;

class Invoice extends Transaction
{
    public function  Invoice()
    {
        $this->TradingTerms = new TradingTerms();
        $this->QuickPayment = new QuickPayment();
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
    public $items = array();
    public $quickPayment;

    public $tradingTerms;
    public $isSent;

    public $totalAmountInclTax;

    public $totalAmountExclTax;

    public $totalTaxAmount;
}
