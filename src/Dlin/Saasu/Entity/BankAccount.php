<?php
namespace Dlin\Saasu\Entity;

use Dlin\Saasu\Validator\Validator;

class BankAccount extends TransactionCategory
{


    public $displayName;
    public $bsb;
    public $accountNumber;
    public $merchantFeeAccountUid;


    public function validate($forUpdate = false)
    {

        return Validator::instance()->
            lookAt($this->uid, 'uid')->required($forUpdate)->int()->
            lookAt($this->lastUpdatedUid, 'lastUpdatedUid')->required($forUpdate)->int()->
            lookAt($this->type, 'type')->enum('Asset', 'Equity', 'Liability')->
            lookAt($this->type, 'type')->required()->length(1)->
            lookAt($this->done, 'done')->enum('true', 'false')->
            lookAt($this->title, 'title')->required()->length(1, 128)->
            lookAt($this->details, 'details')->
            lookAt($this->due, 'due')->date()->
            lookAt($this->lastModified, 'lastModified')->dateTime()->
            lookAt($this->owner, 'owner')->email()->
            lookAt($this->attachedToType, 'attachedToType')->enum('Contact', 'Sale', 'Purchase', 'Employee')->
            lookAt($this->attachedToUid, 'attachedToUid')->int()->getErrors();

    }
}
