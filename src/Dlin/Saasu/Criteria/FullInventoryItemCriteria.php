<?php
/**
 *
 * User: davidlin
 * Date: 23/06/13
 * Time: 12:15 AM
 *
 */

namespace Dlin\Saasu\Criteria;


use Dlin\Saasu\Validator\Validator;

class FullInventoryItemCriteria extends CriteriaBase
{

    public function getEntityClass()
    {
        return "Dlin\\Saasu\\Entity\\InventoryItem";
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