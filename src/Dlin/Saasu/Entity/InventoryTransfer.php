<?php
namespace Dlin\Saasu\Entity;

class InventoryTransfer extends EntityBase
{
    public function __construct($uid = null)
    {
        parent::__construct($uid);
        $this->items = array();
    }

    public $date;

    public $tags;

    public $summary;

    public $notes;

    public $requiresFollowUp = false;


    public $items;
}
