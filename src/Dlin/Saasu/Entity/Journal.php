<?php
namespace Dlin\Saasu\Entity;

class Journal extends Transaction
{

    public function __construct(){
        $this->items = array();
    }


    public $reference;

    public $items;
}
