<?php 
namespace Dlin\Saasu\Entity;

class ContactCategory extends EntityBase
{
    public function __construct($uid=null){
        parent::__construct($uid);
    }

    public $type;
	 public $name;
}
