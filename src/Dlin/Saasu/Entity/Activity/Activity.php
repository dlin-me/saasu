<?php
namespace Dlin\Saasu\Entity\Activity;

use \Dlin\Saasu\Entity\EntityBase;

class Activity extends EntityBase
{

    public $type;
    public $done;
    public $title;
    public $details;
    public $due;

    /**
     * The lastModified timestamp that was received part of a previous get/insert or update
     * @var
     */
    public $lastModified;

    /**
     * Email address of the owner
     * @var
     */
    public $owner;

    /**
     * Contact, Sale, Purchase, Employee
     * @var
     */
    public $attachedToType;
    public $attachedToUid;
}
