<?php
/**
 * 
 * User: davidlin
 * Date: 22/06/13
 * Time: 11:57 PM
 * 
 */

namespace Dlin\Saasu\Criteria;


use Dlin\Saasu\Validator\Validator;

class TagCriteria extends CriteriaBase {
    public function getEntityClass()
    {
        return "Dlin\\Saasu\\Entity\\Tag";
    }

    public $isActive;


    public function validate()
    {

        return Validator::instance()->
            lookAt($this->isActive, 'isActive')->bool();

    }
}