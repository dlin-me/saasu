<?php
namespace Dlin\Saasu\Entity;

use Dlin\Saasu\Entity\InventoryItem;

class ComboItem extends InventoryItem
{

    public function __construct()
    {
        $this->items = array();
    }


    public $items;
}

