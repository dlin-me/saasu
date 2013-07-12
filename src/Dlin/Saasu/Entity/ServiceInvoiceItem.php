<?php
namespace Dlin\Saasu\Entity;

use Dlin\Saasu\Validator\Validator;

class ServiceInvoiceItem extends EntityBase
{
    public function __construct($uid = null)
    {
        parent::__construct($uid);
    }

    public $description;
    public $accountUid;
    public $taxCode;

    public $totalAmountInclTax;

    public $totalAmountExclTax;

    public $totalTaxAmount;
    public $tags;

    public function validate()
    {


        return Validator::instance()->
            lookAt($this->accountUid, 'accountUid')->int()->required(true)->
            lookAt($this->totalAmountInclTax, 'totalAmountInclTax')->numeric()->required(true)->
            lookAt($this->totalAmountExclTax, 'totalAmountExclTax')->numeric()->
            lookAt($this->totalTaxAmount, 'totalTaxAmount')->numeric();

    }
}
