<?php
namespace Dlin\Saasu\Entity;

class InvoicePaymentItem extends EntityBase
{

    public function __construct($uid=null){
        parent::__construct($uid);
    }


    public $invoiceUid;
    public $amount;
}
