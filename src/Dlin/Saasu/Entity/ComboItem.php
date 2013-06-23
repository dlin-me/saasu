<?php
namespace Dlin\Saasu\Entity;

use Dlin\Saasu\Entity\InventoryItem;

class ComboItem extends InventoryItem
{

    public function __construct($uid=null){
        parent::__construct($uid);
        $this->items = array();
    }

    public $items;
}

