<?php
/**
 *
 * User: davidlin
 * Date: 14/06/13
 * Time: 11:56 PM
 *
 */

namespace Dlin\Saasu\Criteria;


use Dlin\Saasu\Enum\AccountType;
use Dlin\Saasu\Validator\Validator;

class BankAccountCriteria extends CriteriaBase
{

    public $type;
    public $isActive;
    public $isInbuilt;


    public function getEntityClass(){
        return "Dlin\\Saasu\\Entity\\BankAccount";
    }


    public function validate()
    {
        return Validator::instance()->
            lookAt($this->type, 'type')->inArray(AccountType::values())->
            lookAt($this->isActive, 'isActive')->bool()->
            lookAt($this->isInbuilt, 'isInbuilt')->bool()->getErrors();

    }
}