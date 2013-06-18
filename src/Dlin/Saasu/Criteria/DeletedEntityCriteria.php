<?php
/**
 *
 * User: davidlin
 * Date: 17/06/13
 * Time: 2:06 PM
 *
 */

namespace Dlin\Saasu\Criteria;


use Dlin\Saasu\Enum\EntityTypeUid;
use Dlin\Saasu\Validator\Validator;

class DeletedEntityCriteria extends CriteriaBase
{

    public $entityTypeUid;
    public $utcDeletedFrom;
    public $utcDeletedTo;

    public function getEntityClass()
    {
        return "Dlin\\Saasu\\Entity\\DeletedEntity";
    }


    public function validate()
    {
        return Validator::instance()->
            lookAt($this->entityTypeUid, 'entityTypeUid')->inArray(EntityTypeUid::values())->
            lookAt($this->utcDeletedFrom, 'utcDeletedFrom')->dateTime()->exnor($this->utcDeletedTo)->
            lookAt($this->utcDeletedTo, 'utcDeletedTo')->dateTime()->getErrors();

    }


}