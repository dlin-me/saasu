<?php
/**
 *
 * User: davidlin
 * Date: 14/06/13
 * Time: 11:53 PM
 *
 */

namespace Dlin\Saasu\Criteria;


use Dlin\Saasu\Enum\InvoiceStatus;
use Dlin\Saasu\Enum\PaidStatus;
use Dlin\Saasu\Validator\Validator;

class InvoiceCriteria extends CriteriaBase
{

    public $transactionType;
    public $paidStatus;
    public $invoiceStatus;
    public $invoiceDateFrom;
    public $invoiceDateTo;

    public $invoiceDueDateFrom;
    public $invoiceDueDateTo;

    public $contactUid;

    public $includeAllTags;

    public $includeAnyTags;

    public $excludeAnyTags;

    public $excludeAllTags;

    public $isSent;

    public $invoiceNumberBeginsWith;

    public $purchaseOrderNumberBeginsWith;

    public $utcLastModifiedFrom;

    public $utcLastModifiedTo;


    public function getEntityClass()
    {
        return "Dlin\\Saasu\\Entity\\Invoice";
    }


    public function validate()
    {
        return Validator::instance()->
            lookAt($this->transactionType, 'transactionType')->required(true)->enum('S', 'P')->
            lookAt($this->paidStatus, 'paidStatus')->inArray(PaidStatus::values())->
            lookAt($this->invoiceStatus, 'invoiceStatus')->inArray(InvoiceStatus::values())->
            lookAt($this->invoiceDateFrom, 'invoiceDateFrom')->date()->exnor($this->invoiceDateTo)->
            lookAt($this->invoiceDateTo, 'invoiceDateTo')->date()->
            lookAt($this->invoiceDueDateFrom, 'invoiceDueDateFrom')->date()->exnor($this->invoiceDueDateTo)->
            lookAt($this->invoiceDueDateTo, 'invoiceDueDateTo')->date()->
            lookAt($this->contactUid, 'contactUid')->int()->
            lookAt($this->includeAllTags, 'includeAllTags')->exor($this->includeAnyTags)->regex('/[\w]+(,[\w]+)*/')->
            lookAt($this->includeAnyTags, 'includeAnyTags')->exor($this->includeAllTags)->regex('/[\w]+(,[\w]+)*/')->
            lookAt($this->excludeAnyTags, 'excludeAnyTags')->exor($this->excludeAllTags)->regex('/[\w]+(,[\w]+)*/')->
            lookAt($this->excludeAllTags, 'excludeAllTags')->exor($this->excludeAnyTags)->regex('/[\w]+(,[\w]+)*/')->
            lookAt($this->isSent, 'isSent')->bool()->
            lookAt($this->utcLastModifiedFrom, 'utcLastModifiedFrom')->dateTime()->exnor($this->utcLastModifiedTo)->
            lookAt($this->utcLastModifiedTo, 'utcLastModifiedFrom')->dateTime()->exnor($this->utcLastModifiedFrom)->
            lookAt($this->contactUid, 'contactUid')->int()->getErrors();

    }

}