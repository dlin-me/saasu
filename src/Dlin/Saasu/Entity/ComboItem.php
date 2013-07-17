<?php
namespace Dlin\Saasu\Entity;

use Dlin\Saasu\Entity\InventoryItem;

class ComboItem extends InventoryItem
{

    public function __construct($uid=null){
        parent::__construct($uid);
        $this->items = array();
        $this->_arrayElementTypes = array('items'=>'ComboItemItem');
    }

    public $items;

    /**
     * This override the parent to specify extra validation
     *
     * @param bool $forUpdate
     * @return $this|\Dlin\Saasu\Validator\Validator
     */
    public function validate($forUpdate = false)
    {
        return parent::validate($forUpdate)->lookAt($this->items, 'items')->countArray(2);
    }

}

