<?php
namespace Dlin\Saasu\Entity;

use Dlin\Saasu\Validator\Validator;

class InventoryTransfer extends EntityBase
{
    public function __construct($uid = null)
    {
        parent::__construct($uid);
        $this->items = array();
    }


    public $tags;

    public $summary;


    public $requiresFollowUp;


    public $items;

    public function validate($forUpdate = false)
    {

        return Validator::instance()->
            lookAt($this->uid, 'uid')->required($forUpdate)->int()->
            lookAt($this->lastUpdatedUid, 'lastUpdatedUid')->required($forUpdate)->int()->
            lookAt($this->summary, 'summary')->length(0, 75)->
            lookAt($this->requiresFollowUp, 'requiresFollowUp')->bool();
    }

}
