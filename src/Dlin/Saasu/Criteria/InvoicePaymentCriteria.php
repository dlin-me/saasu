<?php
/**
 *
 * User: davidlin
 * Date: 22/06/13
 * Time: 11:32 PM
 *
 */

namespace Dlin\Saasu\Criteria;


use Dlin\Saasu\Validator\Validator;

class InvoicePaymentCriteria extends CriteriaBase
{
    public function getEntityClass()
    {
        return "Dlin\\Saasu\\Entity\\InvoicePayment";
    }

    public $transactionType;
    public $paymentDateFrom; //date
    public $paymentDateTo; //date
    public $dateClearedFrom; //date
    public $dateClearedTo; //date
    public $utcLastModifiedFrom;
    public $utcLastModifiedTo;
    public $bankAccountUid;


    public function validate()
    {
        return Validator::instance()->
            lookAt($this->transactionType, 'transactionType')->required(true)->enum('SP','PP')->
            lookAt($this->paymentDateFrom, 'paymentDateFrom')->date()->
            lookAt($this->paymentDateTo, 'paymentDateTo')->date()->
            lookAt($this->dateClearedFrom, 'dateClearedFrom')->date()->
            lookAt($this->dateClearedTo, 'dateClearedTo')->date()->
            lookAt($this->utcLastModifiedFrom, 'utcLastModifiedFrom;')->dateTime()->exnor($this->utcLastModifiedTo)->
            lookAt($this->utcLastModifiedTo, 'utcLastModifiedTo')->dateTime()->exnor($this->utcLastModifiedFrom)->
            lookAt($this->bankAccountUid, 'bankAccountUid')->int();

    }

}