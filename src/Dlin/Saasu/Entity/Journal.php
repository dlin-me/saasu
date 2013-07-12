<?php
namespace Dlin\Saasu\Entity;

use Dlin\Saasu\Validator\Validator;

class Journal extends EntityBase
{

    public function __construct($uid=null){
        parent::__construct($uid);
        $this->journalItems = array();
    }

    public $date;
    public $tags;
    public $summary;
    public $notes;
    public $requiresFollowUp;
    public $ccy;
    public $autoPopulateFxRate;
    public $fcToBcFxRate;

    public $reference;

    public $journalItems;



    public function validate($forUpdate = false)
    {


        return Validator::instance()->
            lookAt($this->uid, 'uid')->required($forUpdate)->int()->
            lookAt($this->lastUpdatedUid, 'lastUpdatedUid')->required($forUpdate)->int()->
            lookAt($this->summary, 'summary')->length(0,75)->
            lookAt($this->requiresFollowUp, 'requiresFollowUp')->bool()->
            lookAt($this->journalItems, 'journalItems')->required(true)->
            lookAt($this->ccy, 'ccy')->length(0,3)->
            lookAt($this->autoPopulateFxRate, 'autoPopulateFxRate')->bool()->
            lookAt($this->fcToBcFxRate, 'fcToBcFxRate')->numeric()->
            lookAt($this->reference, 'reference')->length(0,50);

    }
}
