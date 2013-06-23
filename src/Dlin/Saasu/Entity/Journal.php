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
}
