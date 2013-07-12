<?php
/**
 *
 * User: davidlin
 * Date: 22/06/13
 * Time: 11:32 PM
 *
 */

namespace Dlin\Saasu\Criteria;


use Dlin\Saasu\Enum\SearchFieldName;
use Dlin\Saasu\Validator\Validator;

class ContactCriteria extends CriteriaBase
{
    public function getEntityClass()
    {
        return "Dlin\\Saasu\\Entity\\Contact";
    }

    public $includeAllTags;
    public $includeAnyTags;
    public $excludeAnyTags;
    public $excludeAllTags;
    public $isActive;
    public $searchFieldName;
    public $searchFieldNameBeginsWith;
    public $contactId;
    public $givenName;
    public $familyName;
    public $organisationName;
    public $utcLastModifiedFrom;
    public $utcLastModifiedTo;


    public function validate()
    {
        return Validator::instance()->
            lookAt($this->includeAllTags, 'includeAllTags')->exor($this->includeAnyTags)->regex('/[\w]+(,[\w]+)*/')->
            lookAt($this->includeAnyTags, 'includeAnyTags')->exor($this->includeAllTags)->regex('/[\w]+(,[\w]+)*/')->
            lookAt($this->excludeAnyTags, 'excludeAnyTags')->exor($this->excludeAllTags)->regex('/[\w]+(,[\w]+)*/')->
            lookAt($this->excludeAllTags, 'excludeAllTags')->exor($this->excludeAnyTags)->regex('/[\w]+(,[\w]+)*/')->
            lookAt($this->isActive, 'isSent')->bool()->
            lookAt($this->searchFieldName, 'searchFieldName')->inArray(SearchFieldName::values())->
            lookAt($this->utcLastModifiedFrom, 'utcLastModifiedFrom;')->dateTime()->exnor($this->utcLastModifiedTo)->
            lookAt($this->utcLastModifiedTo, 'utcLastModifiedTo')->dateTime()->exnor($this->utcLastModifiedFrom);

    }

}