<?php
namespace Dlin\Saasu\Entity;


use Dlin\Saasu\Validator\Validator;

class ComboItemItem extends EntityBase
{
    public function __construct($uid = null)
    {
        parent::__construct($uid);
        $this->_entityName = "Item";
    }

    public $uid;
    public $code;
    public $quantity;

    public function validate()
    {

        return Validator::instance()->
            lookAt($this->uid, 'uid')->int()->
            lookAt($this->quantity, 'quantity')->numeric()->
            getErrors();

    }

}
