<?php
namespace Dlin\Saasu\Entity;


 class ComboItemLineItem extends EntityBase
{
     public function __construct($uid=null){
         parent::__construct($uid);
     }

    public $uid;
    public $code;
    public $quantity;
}
