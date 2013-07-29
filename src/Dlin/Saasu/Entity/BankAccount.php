<?php
namespace Dlin\Saasu\Entity;


use Dlin\Saasu\Validator\Validator;

class BankAccount extends TransactionCategory
{


    public $displayName;
    public $bsb;
    public $accountNumber;
    public $merchantFeeAccountUid;

    /**
     * @param bool $forUpdate
     * @return Validator
     */
    public function validate($forUpdate = false)
    {

        return Validator::instance()->
            lookAt($this->uid, 'uid')->required($forUpdate)->int()->
            lookAt($this->lastUpdatedUid, 'lastUpdatedUid')->required($forUpdate)->int()->
            lookAt($this->type, 'type')->required(true)->enum('Asset', 'Equity', 'Liability')->
            lookAt($this->name, 'name')->length(0,75)->
            lookAt($this->isActive, 'isActive')->bool()->
            lookAt($this->displayName, 'displayName')->required(true)->length(0,75)->
            lookAt($this->bsb, 'bsb')->length(0,6)->
            lookAt($this->accountNumber, 'accountNumber')->length(0,20);

    }
}
