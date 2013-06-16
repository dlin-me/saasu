<?php
namespace Dlin\Saasu\Entity;

class Checkout extends EntityBase
{

    public $billingContact;
    public $shippingContact;
    public $sale;
    public $paymentAmount;
    public $emailReceipt;
    public $emailReceiptUsingTemplateUid;

    public function __construct()
    {
        parent::__construct();

        $this->billingContact = new Contact();
        $this->shippingContact = new Contact();
        $this->sale = new Invoice();
    }
}
