<?php
namespace Dlin\Saasu\Entity;

use Dlin\Saasu\Enum\AccountType;
use Dlin\Saasu\Validator\Validator;

class TransactionCategory extends EntityBase
{

    public function __construct($uid=null){
        parent::__construct($uid);
    }


    public $type;
    public $name;
    public $isActive;
    public $ledgerCode;
    public $defaultTaxCode;

    public function validate($forUpdate)
    {
        return Validator::instance()->
            lookAt($this->uid, 'uid')->required($forUpdate)->int()->
            lookAt($this->lastUpdatedUid, 'lastUpdatedUid')->required($forUpdate)->int()->
            lookAt($this->type, 'type')->length(0,50)->inArray(AccountType::values())->required(true)->
            lookAt($this->name, 'name')->length(1.75)->required(true)->
            lookAt($this->isActive, 'isActive')->bool();

    }
}
