<?php
namespace Dlin\Saasu\Entity;

class InsertUpdateResult extends EntityBase
{
    public function __construct($uid=null){
        parent::__construct($uid);
    }


    public $uid;
    public $lastUpdatedUid;
}
