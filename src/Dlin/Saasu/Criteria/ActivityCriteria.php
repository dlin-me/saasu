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

class ActivityCriteria extends CriteriaBase
{
    public function getEntityClass()
    {
        return "Dlin\\Saasu\\Entity\\Activity";
    }

    public $type;
    public $status;
    public $owner; //email
    public $search;
    public $dateType;
    public $periodType;
    public $attachedToType;
    public $attachedToUid;


    public $dateFrom;
    public $dateTo;

    public $includeAllTags;
    public $includeAnyTags;
    public $excludeAnyTags;
    public $excludeAllTags;
    public $utcLastModifiedFrom;
    public $utcLastModifiedTo;


    public function validate()
    {
        return Validator::instance()->
            lookAt($this->status, 'status;')->enum('todo', 'done', 'overdue')->
            lookAt($this->owner, 'owner;')->email()->
            lookAt($this->dateType, 'dateType;')->enum('due', 'modified')->
            lookAt($this->attachedToUid, 'attachedToUid;')->int()->
            lookAt($this->dateFrom, 'dateFrom;')->dateTime()->
            lookAt($this->dateTo, 'dateTo')->dateTime()->
            lookAt($this->includeAllTags, 'includeAllTags')->exor($this->includeAnyTags)->regex('/[\w]+(,[\w]+)*/')->
            lookAt($this->includeAnyTags, 'includeAnyTags')->exor($this->includeAllTags)->regex('/[\w]+(,[\w]+)*/')->
            lookAt($this->excludeAnyTags, 'excludeAnyTags')->exor($this->excludeAllTags)->regex('/[\w]+(,[\w]+)*/')->
            lookAt($this->excludeAllTags, 'excludeAllTags')->exor($this->excludeAnyTags)->regex('/[\w]+(,[\w]+)*/')->
            lookAt($this->utcLastModifiedFrom, 'utcLastModifiedFrom;')->dateTime()->exnor($this->utcLastModifiedTo)->
            lookAt($this->utcLastModifiedTo, 'utcLastModifiedTo')->dateTime()->exnor($this->utcLastModifiedFrom);

    }

}