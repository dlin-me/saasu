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

class InventoryTransferCriteria extends CriteriaBase
{
    public function getEntityClass()
    {
        return "Dlin\\Saasu\\Entity\\InventoryTransfer";
    }

    public $dateFrom;
    public $dateTo;
    public $utcLastModifiedFrom;
    public $utcLastModifiedTo;



    public function validate()
    {
        return Validator::instance()->

            lookAt($this->dateFrom, 'dateFrom;')->dateTime()->
            lookAt($this->dateTo, 'dateTo;')->dateTime()->
            lookAt($this->utcLastModifiedFrom, 'utcLastModifiedFrom;')->dateTime()->exnor($this->utcLastModifiedTo)->
            lookAt($this->utcLastModifiedTo, 'utcLastModifiedTo')->dateTime()->exnor($this->utcLastModifiedFrom);

    }


}