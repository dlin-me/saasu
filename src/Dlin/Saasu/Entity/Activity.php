<?php
namespace Dlin\Saasu\Entity;

use Dlin\Saasu\Entity\EntityBase;
use Dlin\Saasu\Validator\Validator;

class Activity extends EntityBase
{
    public function __construct($uid=null){
        parent::__construct($uid);
    }

    public $type; //Valid values: All tags with activity flag set to true.
    public $done; //boolean, true of false
    public $title; //max 128 length
    public $details;
    public $due; //Date iso 8601   yyyy-mm-dd

    /**
     * The lastModified timestamp that was received part of a previous get/insert or update
     * @var
     */
    public $lastModified; //datetime iso 8601 php date('c'); e.g. 2011-01-01T10:25:30

    public $utcFirstCreated; //datetime iso 8601 php date('c'); e.g. 2011-01-01T10:25:30

    /**
     * Email address of the owner
     * @var
     */
    public $owner; //Owner/user responsible for this activity

    /**
     * Contact, Sale, Purchase, Employee
     * @see \Dlin\Saasu\Enum\ActivityAttachedToType
     * @var
     */
    public $attachedToType;
    public $attachedToUid; //int

    /**
     * @param bool $forUpdate
     * @return Validator
     */
    public function validate($forUpdate = false)
    {

        return Validator::instance()->
            lookAt($this->uid, 'uid')->required($forUpdate)->int()->
            lookAt($this->lastUpdatedUid, 'lastUpdatedUid')->required($forUpdate)->int()->
            lookAt($this->utcFirstCreated, 'utcFirstCreated')->dateTime()->
            lookAt($this->type, 'type')->required(true)->length(1)->
            lookAt($this->done, 'done')->enum('true', 'false')->
            lookAt($this->title, 'title')->required(true)->length(1, 128)->
            lookAt($this->details, 'details')->
            lookAt($this->due, 'due')->date()->
            lookAt($this->lastModified, 'lastModified')->dateTime()->
            lookAt($this->owner, 'owner')->email()->
            lookAt($this->attachedToType, 'attachedToType')->enum('Contact', 'Sale', 'Purchase', 'Employee')->
            lookAt($this->attachedToUid, 'attachedToUid')->int();

    }
}
