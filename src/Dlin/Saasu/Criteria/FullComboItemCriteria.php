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

class FullComboItemCriteria extends CriteriaBase
{
    public function getEntityClass()
    {
        return "Dlin\\Saasu\\Entity\\ComboItem";
    }

    public $isActive;
    public $codeBeginsWith;
    public $descriptionBeginsWith;
    public $utcLastModifiedFrom;
    public $utcLastModifiedTo;



    public function validate()
    {
        return Validator::instance()->
            lookAt($this->isActive, 'isSent')->bool()->
            lookAt($this->utcLastModifiedFrom, 'utcLastModifiedFrom;')->dateTime()->exnor($this->utcLastModifiedTo)->
            lookAt($this->utcLastModifiedTo, 'utcLastModifiedTo')->dateTime()->exnor($this->utcLastModifiedFrom);

    }


}