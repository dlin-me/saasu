<?php
namespace Dlin\Saasu\Entity;

class Journal extends Transaction
{

    public function __construct($uid=null){
        parent::__construct($uid);
        $this->items = array();
    }


    public $reference;

    public $items;


    public function validate($forUpdate = false)
    {


        return Validator::instance()->
            lookAt($this->uid, 'uid')->required($forUpdate)->int()->
            lookAt($this->lastUpdatedUid, 'lastUpdatedUid')->required($forUpdate)->int()->
            lookAt($this->summary, 'summary')->length(0,75)->
            lookAt($this->requiresFollowUp, 'requiresFollowUp')->bool()->
            lookAt($this->journalitems, 'journalitems')->required()->
            getErrors();

    }
}
