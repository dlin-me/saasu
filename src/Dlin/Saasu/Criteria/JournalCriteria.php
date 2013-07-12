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

class JournalCriteria extends CriteriaBase
{
    public function getEntityClass()
    {
        return "Dlin\\Saasu\\Entity\\Journal";
    }


    public $journalDateFrom;
    public $journalDateTo;

    public $includeAllTags;
    public $includeAnyTags;
    public $excludeAnyTags;
    public $excludeAllTags;
    public $utcLastModifiedFrom;
    public $utcLastModifiedTo;


    public function validate()
    {
        return Validator::instance()->
            lookAt($this->journalDateFrom, 'journalDateFrom;')->dateTime()->
            lookAt($this->journalDateTo, 'journalDateTo')->dateTime()->
            lookAt($this->includeAllTags, 'includeAllTags')->exor($this->includeAnyTags)->regex('/[\w]+(,[\w]+)*/')->
            lookAt($this->includeAnyTags, 'includeAnyTags')->exor($this->includeAllTags)->regex('/[\w]+(,[\w]+)*/')->
            lookAt($this->excludeAnyTags, 'excludeAnyTags')->exor($this->excludeAllTags)->regex('/[\w]+(,[\w]+)*/')->
            lookAt($this->excludeAllTags, 'excludeAllTags')->exor($this->excludeAnyTags)->regex('/[\w]+(,[\w]+)*/')->
            lookAt($this->utcLastModifiedFrom, 'utcLastModifiedFrom;')->dateTime()->exnor($this->utcLastModifiedTo)->
            lookAt($this->utcLastModifiedTo, 'utcLastModifiedTo')->dateTime()->exnor($this->utcLastModifiedFrom);

    }

}