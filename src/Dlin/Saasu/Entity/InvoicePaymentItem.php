<?php
namespace Dlin\Saasu\Entity;

use Dlin\Saasu\Validator\Validator;

class InvoicePaymentItem extends EntityBase
{

    public function __construct($uid=null){
        parent::__construct($uid);
    }


    public $invoiceUid;
    public $amount;

    /**
     * @return Validator
     */
    public function validate(){

        return Validator::instance()->
            lookAt($this->invoiceUid, 'invoiceUid')->required(true)->int()->
            lookAt($this->amount, 'amount')->required(true)->numeric();
    }
}
