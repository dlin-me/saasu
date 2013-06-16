<?php
namespace Dlin\Saasu\Entity;

class InventoryAdjustment extends EntityBase
{
    public function __construct($uid=null){
        parent::__construct($uid);
    }

    public $date;

    public $tags;

    public $summary;

    public $notes;

    public $requiresFollowUp = false;


    public $items = array();
}
