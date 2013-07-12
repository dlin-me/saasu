<?php
namespace Dlin\Saasu\Entity;

use Dlin\Saasu\Validator\Validator;

class InventoryAdjustment extends EntityBase
{
    public function __construct($uid=null){
        parent::__construct($uid);
        $this->items = array();
    }

    public $date;

    public $tags;

    public $summary;

    public $notes;

    public $requiresFollowUp;


    public $items;

    public function validate($forUpdate = false){

        return Validator::instance()->
            lookAt($this->uid, 'uid')->required($forUpdate)->int()->
            lookAt($this->lastUpdatedUid, 'lastUpdatedUid')->required($forUpdate)->int()->
            lookAt($this->summary, 'summary')->length(0,75)->
            lookAt($this->requiresFollowUp, 'requiresFollowUp')->bool();
    }
}
